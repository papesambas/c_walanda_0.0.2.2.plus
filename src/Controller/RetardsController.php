<?php

namespace App\Controller;

use App\Entity\Retards;
use App\Form\RetardsType;
use App\Data\SearchElevesData;
use App\Entity\Eleves;
use App\Form\SearchElevesDataType;
use App\Repository\AnneeScolairesRepository;
use App\Repository\ElevesRepository;
use App\Repository\RetardsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/retards')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class RetardsController extends AbstractController
{
    #[IsGranted('ROLE_SURVEILLANT')]
    #[Route(name: 'app_retards_eleves', methods: ['GET'])]
    public function liste(ElevesRepository $elevesRepository, Request $request): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);

        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->where('e.isActif = :actif')
            ->andWhere('e.isAdmis = :admis') // Utilisation de andWhere()
            ->setParameter('actif', true)
            ->setParameter('admis', true);

        // Application des filtres supplémentaires si formulaire soumis
        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($searchData->q)) {
                $queryBuilder->andWhere('e.fullname LIKE :q')
                    ->setParameter('q', '%' . $searchData->q . '%');
            }

            if ($searchData->age1 !== null) {
                $queryBuilder->andWhere('e.age >= :age1')
                    ->setParameter('age1', $searchData->age1);
            }

            if ($searchData->age2 !== null) {
                $queryBuilder->andWhere('e.age <= :age2')
                    ->setParameter('age2', $searchData->age2);
            }

            if (!$searchData->statut->isEmpty()) {
                $designations = $searchData->statut->map(function ($statut) {
                    return $statut->getDesignation();
                })->toArray();

                $queryBuilder
                    ->leftJoin('e.statut', 's')
                    ->andWhere('s.designation IN (:statuts)')
                    ->setParameter('statuts', $designations);
            }

            if (!$searchData->classe->isEmpty()) {
                $queryBuilder->andWhere('e.classe IN (:classes)')
                    ->setParameter('classes', $searchData->classe);
            }
        }

        // Exécution de la requête
        $eleves = $queryBuilder
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('retards/eleves.html.twig', [
            'eleves' => $eleves,
            'form' => $form->createView()
        ]);
    }

    #[IsGranted('ROLE_SURVEILLANT')]
    #[Route('/index', name: 'app_retards_index', methods: ['GET'])]
    public function index(RetardsRepository $retardsRepository): Response
    {
        return $this->render('retards/index.html.twig', [
            'retards' => $retardsRepository->findAll(),
        ]);
    }

    #[Route('{slug}/new', name: 'app_retards_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        Eleves $eleve,
        EntityManagerInterface $entityManager,
        AnneeScolairesRepository $anneeScolairesRepository
    ): Response {
        $retard = new Retards();
        $annee = $anneeScolairesRepository->findCurrentYear();
    
        // Configuration des dates/heures
        $current = new \DateTimeImmutable();
        $currentDay = $current->setTime(0, 0, 0); // Date du jour à minuit
        $currentTimeString = $current->format('H:i');
    
        // Détermination de l'heure de cours théorique
        $heureClasse = $this->determinerHeureClasse($currentTimeString, $currentDay);
    
        if ($heureClasse) {
            // Calcul du retard
            $dureeRetard = $this->calculerDureeRetard($current, $heureClasse);
            
            // Hydratation de l'entité
            $retard
                ->setJour($currentDay)
                ->setHeure($current)
                ->setHeureClasse($heureClasse)
                ->setDuree($dureeRetard)
                ->setEleves($eleve)
                ->setAnneeScolaire($annee);
        }
    
        // Gestion du formulaire
        $form = $this->createForm(RetardsType::class, $retard);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($retard);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_retards_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('retards/new.html.twig', [
            'retard' => $retard,
            'form' => $form,
        ]);
    }
    
    private function determinerHeureClasse(string $heureActuelle, \DateTimeImmutable $jour): ?\DateTimeImmutable
    {
        return match (true) {
            // Premier cours (07:30 - 09:50)
            $heureActuelle >= '07:30' && $heureActuelle < '09:50' => $jour->setTime(7, 40),
            
            // Deuxième cours (10:00 - 12:00)
            $heureActuelle >= '10:00' && $heureActuelle < '12:00' => $jour->setTime(10, 0),
            
            // Cours de l'après-midi (15:00 - 17:00)
            $heureActuelle >= '15:00' && $heureActuelle < '17:00' => $jour->setTime(15, 0),
            
            default => null
        };
    }
    
    private function calculerDureeRetard(\DateTimeImmutable $heureArrivee, \DateTimeImmutable $heureCours): \DateTimeImmutable
    {

    // Vérifier si l'élève est à l'heure ou en avance
    if ($heureArrivee <= $heureCours) {
        return new \DateTimeImmutable('1970-01-01 00:00:00'); // Pas de retard (0h 0m 0s)
    }

    $interval = $heureCours->diff($heureArrivee); // Retourne un DateInterval

    // Appliquer l'intervalle à une date de référence
    return (new \DateTimeImmutable('1970-01-01 00:00:00'))->add($interval);
    }

    #[Route('/{id}', name: 'app_retards_show', methods: ['GET'])]
    public function show(Retards $retard): Response
    {
        return $this->render('retards/show.html.twig', [
            'retard' => $retard,
        ]);
    }

    #[IsGranted('ROLE_SURVEILLANT')]
    #[Route('/{id}/edit', name: 'app_retards_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Retards $retard, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RetardsType::class, $retard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_retards_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('retards/edit.html.twig', [
            'retard' => $retard,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_SURVEILLANT')]
    #[Route('/{id}', name: 'app_retards_delete', methods: ['POST'])]
    public function delete(Request $request, Retards $retard, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $retard->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($retard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_retards_index', [], Response::HTTP_SEE_OTHER);
    }
}
