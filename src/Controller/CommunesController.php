<?php

namespace App\Controller;

use App\Entity\Communes;
use App\Form\CommunesType;
use App\Data\SearchElevesData;
use App\Form\SearchElevesDataType;
use App\Repository\ElevesRepository;
use App\Repository\CommunesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/communes')]
final class CommunesController extends AbstractController
{
    #[Route(name: 'app_communes_index', methods: ['GET'])]
    public function index(CommunesRepository $communesRepository): Response
    {
        return $this->render('communes/index.html.twig', [
            'communes' => $communesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_communes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commune = new Communes();
        $form = $this->createForm(CommunesType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commune);
            $entityManager->flush();

            return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('communes/new.html.twig', [
            'commune' => $commune,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_communes_show', methods: ['GET'])]
    public function show(Request $request, ElevesRepository $elevesRepository, Communes $commune): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);

        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->leftjoin('e.lieuNaissance', 'ln')  // Jointure avec LieuNaissance
            ->andWhere('ln.commune = :commune')   // Filtrer sur le nom de la commune
            ->setParameter('commune', $commune)
            ->orderBy('e.fullname', 'ASC');
            //->getQuery()
            //->getResult();


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
            'commune' => $commune,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_communes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Communes $commune, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommunesType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('communes/edit.html.twig', [
            'commune' => $commune,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_communes_delete', methods: ['POST'])]
    public function delete(Request $request, Communes $commune, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commune->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($commune);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
    }
}
