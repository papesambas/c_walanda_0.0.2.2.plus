<?php

namespace App\Controller;

use App\Entity\Regions;
use App\Form\RegionsType;
use App\Data\SearchElevesData;
use App\Form\SearchElevesDataType;
use App\Repository\ElevesRepository;
use App\Repository\RegionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/regions')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class RegionsController extends AbstractController
{
    #[Route(name: 'app_regions_index', methods: ['GET'])]
    public function index(RegionsRepository $regionsRepository): Response
    {
        return $this->render('regions/index.html.twig', [
            'regions' => $regionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_regions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $region = new Regions();
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($region);
            $entityManager->flush();

            return $this->redirectToRoute('app_regions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regions/new.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_regions_show', methods: ['GET'])]
    public function show(Request $request,ElevesRepository $elevesRepository, Regions $region): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);
    
        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
        ->leftjoin('e.lieuNaissance', 'ln')  // Jointure avec LieuNaissance
        ->leftjoin('ln.commune', 'co')        // Jointure avec Commune
        ->leftjoin('co.cercle', 'c')        // Jointure avec Commune
        ->andWhere('c.region = :region')   // Filtrer sur le nom de la commune
        ->setParameter('region', $region)
        ->orderBy('e.fullname', 'ASC');
    
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
            'region' => $region,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_regions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Regions $region, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_regions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regions/edit.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_regions_delete', methods: ['POST'])]
    public function delete(Request $request, Regions $region, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($region);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_regions_index', [], Response::HTTP_SEE_OTHER);
    }
}
