<?php

namespace App\Controller;

use App\Data\SearchElevesData;
use App\Entity\EcoleProvenances;
use App\Form\EcoleProvenancesType;
use App\Form\SearchElevesDataType;
use App\Repository\ElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EcoleProvenancesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ecole/provenances')]
final class EcoleProvenancesController extends AbstractController
{
    #[Route(name: 'app_ecole_provenances_index', methods: ['GET'])]
    public function index(EcoleProvenancesRepository $ecoleProvenancesRepository): Response
    {
        return $this->render('ecole_provenances/index.html.twig', [
            'ecole_provenances' => $ecoleProvenancesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ecole_provenances_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ecoleProvenance = new EcoleProvenances();
        $form = $this->createForm(EcoleProvenancesType::class, $ecoleProvenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ecoleProvenance);
            $entityManager->flush();

            return $this->redirectToRoute('app_ecole_provenances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ecole_provenances/new.html.twig', [
            'ecole_provenance' => $ecoleProvenance,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_ecole_provenances_show', methods: ['GET'])]
    public function show(Request $request, ElevesRepository $elevesRepository, EcoleProvenances $ecoleProvenance): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);

        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->andWhere(':ecole MEMBER OF e.ecoleAnDernier')
            ->orWhere('e.ecoleRecrutement = :ecole')   // Filtrer sur le nom de la commune
            ->setParameter('ecoleAnDernier', $ecoleProvenance)
            ->setParameter('ecole', $ecoleProvenance)
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
            'ecoleProvenance' => $ecoleProvenance,
            'form' => $form->createView()
        ]);
    }

    #[Route('/an/dernier/{slug}', name: 'app_ecole_an_dernier_show', methods: ['GET'])]
    public function AnDerniershow(Request $request, ElevesRepository $elevesRepository, EcoleProvenances $ecoleProvenance): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);

        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
        ->andWhere(':ecoleAnDernier MEMBER OF e.ecoleAnDernier') // Changement ici
        ->setParameter('ecoleAnDernier', $ecoleProvenance) // Correspondance OK
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
            'ecoleProvenance' => $ecoleProvenance,
            'form' => $form->createView()
        ]);
    }

    #[Route('/recrutement/{slug}', name: 'app_ecole_recrutement_show', methods: ['GET'])]
    public function Recrutementshow(Request $request, ElevesRepository $elevesRepository, EcoleProvenances $ecoleProvenance): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);

        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->andWhere('e.ecoleRecrutement = :ecole')   // Filtrer sur le nom de la commune
            ->setParameter('ecole', $ecoleProvenance)
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
            'ecoleProvenance' => $ecoleProvenance,
            'form' => $form->createView()
        ]);
    }


    #[Route('/{slug}/edit', name: 'app_ecole_provenances_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EcoleProvenances $ecoleProvenance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EcoleProvenancesType::class, $ecoleProvenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ecole_provenances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ecole_provenances/edit.html.twig', [
            'ecole_provenance' => $ecoleProvenance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ecole_provenances_delete', methods: ['POST'])]
    public function delete(Request $request, EcoleProvenances $ecoleProvenance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ecoleProvenance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ecoleProvenance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ecole_provenances_index', [], Response::HTTP_SEE_OTHER);
    }
}
