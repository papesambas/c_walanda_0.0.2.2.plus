<?php

namespace App\Controller;

use App\Data\SearchElevesData;
use App\Entity\LieuNaissances;
use App\Form\LieuNaissancesType;
use App\Form\SearchElevesDataType;
use App\Repository\ElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LieuNaissancesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
#[Route('/lieu/naissances')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class LieuNaissancesController extends AbstractController
{
    #[Route(name: 'app_lieu_naissances_index', methods: ['GET'])]
    public function index(LieuNaissancesRepository $lieuNaissancesRepository): Response
    {
        return $this->render('lieu_naissances/index.html.twig', [
            'lieu_naissances' => $lieuNaissancesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lieu_naissances_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lieuNaissance = new LieuNaissances();
        $form = $this->createForm(LieuNaissancesType::class, $lieuNaissance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lieuNaissance);
            $entityManager->flush();

            return $this->redirectToRoute('app_lieu_naissances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lieu_naissances/new.html.twig', [
            'lieu_naissance' => $lieuNaissance,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_lieu_naissances_show', methods: ['GET'])]
    public function show(
        Request $request,
        ElevesRepository $elevesRepository,
        LieuNaissances $lieuNaissance
    ): Response {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);
    
        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->where('e.lieuNaissance = :lieu')
            ->setParameter('lieu', $lieuNaissance);
    
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
    
        return $this->render('eleves/index.html.twig', [
            'eleves' => $eleves,
            'lieu_naissance' => $lieuNaissance,
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/{slug}/edit', name: 'app_lieu_naissances_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LieuNaissances $lieuNaissance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LieuNaissancesType::class, $lieuNaissance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lieu_naissances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lieu_naissances/edit.html.twig', [
            'lieu_naissance' => $lieuNaissance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lieu_naissances_delete', methods: ['POST'])]
    public function delete(Request $request, LieuNaissances $lieuNaissance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lieuNaissance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($lieuNaissance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lieu_naissances_index', [], Response::HTTP_SEE_OTHER);
    }
}
