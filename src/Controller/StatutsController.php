<?php

namespace App\Controller;

use App\Entity\Statuts;
use App\Form\StatutsType;
use App\Data\SearchElevesData;
use App\Form\SearchElevesDataType;
use App\Repository\ElevesRepository;
use App\Repository\StatutsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/statuts')]
final class StatutsController extends AbstractController
{
    #[Route(name: 'app_statuts_index', methods: ['GET'])]
    public function index(StatutsRepository $statutsRepository): Response
    {
        return $this->render('statuts/index.html.twig', [
            'statuts' => $statutsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_statuts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statut = new Statuts();
        $form = $this->createForm(StatutsType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statut);
            $entityManager->flush();

            return $this->redirectToRoute('app_statuts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('statuts/new.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_statuts_show', methods: ['GET'])]
    public function show(ElevesRepository $elevesRepository, Statuts $statut,Request $request): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);
    
        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->where('e.lieuNaissance = :lieu')
            ->setParameter('lieu', $statut->getDesignation());
    
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
            'statut' => $statut,
            'form' => $form->createView()
        ]);

    }


    #[Route('/{slug}/edit', name: 'app_statuts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statuts $statut, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatutsType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_statuts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('statuts/edit.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statuts_delete', methods: ['POST'])]
    public function delete(Request $request, Statuts $statut, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $statut->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($statut);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_statuts_index', [], Response::HTTP_SEE_OTHER);
    }
}
