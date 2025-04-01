<?php

namespace App\Controller;

use App\Entity\Meres;
use App\Form\MeresType;
use App\Data\SearchData;
use App\Form\SearchDataType;
use App\Data\SearchElevesData;
use App\Form\SearchElevesDataType;
use App\Repository\MeresRepository;
use App\Repository\ElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/meres')]
final class MeresController extends AbstractController
{
    #[Route(name: 'app_meres_index', methods: ['GET'])]
    public function index(Request $request, MeresRepository $meresRepository): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchDataType::class, $data);
        $form->handleRequest($request);
        $meres = $meresRepository->findBySearchData($data);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les résultats filtrés en utilisant le repository
            $meres = $meresRepository->findBySearchData($data);
        } else {
            // Récupérer tous les résultats si aucun critère de recherche n'est fourni
            $meres = $meresRepository->findAll();
        }

        return $this->render('meres/index.html.twig', [
            'meres' => $meres,
            'form' => $form->createView(),
        ]);

    }

    #[Route('/new', name: 'app_meres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mere = new Meres();
        $form = $this->createForm(MeresType::class, $mere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mere);
            $entityManager->flush();

            return $this->redirectToRoute('app_meres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meres/new.html.twig', [
            'mere' => $mere,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_meres_show', methods: ['GET'])]
    public function show(Meres $mere,ElevesRepository $elevesRepository, Request $request): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);

        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
        ->leftjoin('e.parent', 'pa')  // Jointure avec LieuNaissance
        ->andWhere('pa.mere = :mere')   // Filtrer sur le nom de la commune
        ->setParameter('mere', $mere)
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
            'mere' => $mere,
            'form' => $form->createView()
        ]); 
    }

    #[Route('/{slug}/edit', name: 'app_meres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meres $mere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeresType::class, $mere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_meres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meres/edit.html.twig', [
            'mere' => $mere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meres_delete', methods: ['POST'])]
    public function delete(Request $request, Meres $mere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mere->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_meres_index', [], Response::HTTP_SEE_OTHER);
    }
}
