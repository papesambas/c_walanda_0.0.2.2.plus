<?php

namespace App\Controller;

use App\Entity\AnneeScolaires;
use App\Form\AnneeScolairesType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use App\Repository\AnneeScolairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/annee/scolaires')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]

final class AnneeScolairesController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route(name: 'app_annee_scolaires_index', methods: ['GET'])]
    public function index(AnneeScolairesRepository $anneeScolairesRepository): Response
    {
        return $this->render('annee_scolaires/index.html.twig', [
            'annee_scolaires' => $anneeScolairesRepository->findBy([], ['anneeFin' => 'DESC']),
            'current_year' => $anneeScolairesRepository->findCurrentYear(),
        ]);
    }

    #[Route('/new', name: 'app_annee_scolaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $anneeScolaire = new AnneeScolaires();
        
        // Déterminer l'année scolaire en fonction du mois actuel
        $currentYear = (int) (new \DateTime())->format('Y');
        $currentMonth = (int) (new \DateTime())->format('m');
        $anneedebut = ($currentMonth >= 8) ? $currentYear : $currentYear - 1;
        $anneeScolaire->setAnneeDebut($anneedebut);
        $anneeScolaire->setAnneeFin($anneedebut + 1);
    
        // Création du formulaire
        $form = $this->createForm(AnneeScolairesType::class, $anneeScolaire);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            $submittedAnneeDebut = $anneeScolaire->getAnneeDebut();
            $existingAnneeScolaire = $entityManager->getRepository(AnneeScolaires::class)
                ->findOneBy(['anneedebut' => $submittedAnneeDebut]);
    
            if ($existingAnneeScolaire) {
                $form->get('anneedebut')->addError(new FormError('Cette année existe déjà.'));
            }
    
            if ($form->isValid()) {
                // Sauvegarde en base de données
                $anneeScolaire->setAnneeFin($submittedAnneeDebut + 1);
                $entityManager->persist($anneeScolaire);
                $entityManager->flush();
    
                // Si c'est une requête AJAX, on renvoie une réponse JSON
                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse(['success' => true], Response::HTTP_OK);
                }
                $this->addFlash('success', 'Année scolaire créée avec succès');
                return $this->redirectToRoute('app_annee_scolaires_index');
            } else {
                // Si c'est une requête AJAX, renvoyer les erreurs en JSON
                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse([
                        'success' => false,
                        'errors' => $this->getFormErrors($form)
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
        }
    
        return $this->render('annee_scolaires/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/{id}/set-current', name: 'app_annee_scolaires_set_current', methods: ['POST'])]
    public function setCurrentYear(
        AnneeScolaires $anneeScolaire,
        AnneeScolairesRepository $repository
    ): Response {
        // D'abord, on retire le statut "courant" de toutes les années
        $repository->clearCurrentYearStatus();
        
        // Puis on marque l'année sélectionnée comme courante
        $anneeScolaire->setIsCurrent(true);
        $this->entityManager->flush();

        $this->addFlash('success', 'Année scolaire courante mise à jour');
        return $this->redirectToRoute('app_annee_scolaires_index');
    }

    #[Route('/{id}', name: 'app_annee_scolaires_show', methods: ['GET'])]
    public function show(AnneeScolaires $anneeScolaire): Response
    {
        return $this->render('annee_scolaires/show.html.twig', [
            'annee_scolaire' => $anneeScolaire,
            'is_current' => $anneeScolaire->isCurrent(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annee_scolaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnneeScolaires $anneeScolaire): Response
    {
        $form = $this->createForm(AnneeScolairesType::class, $anneeScolaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Année scolaire mise à jour');
            return $this->redirectToRoute('app_annee_scolaires_show', ['id' => $anneeScolaire->getId()]);
        }

        return $this->render('annee_scolaires/edit.html.twig', [
            'annee_scolaire' => $anneeScolaire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_annee_scolaires_delete', methods: ['POST'])]
    public function delete(Request $request, AnneeScolaires $anneeScolaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anneeScolaire->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($anneeScolaire);
            $this->entityManager->flush();
            $this->addFlash('success', 'Année scolaire supprimée');
        }

        return $this->redirectToRoute('app_annee_scolaires_index');
    }

    private function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }
        return $errors;
    }
    
}