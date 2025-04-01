<?php

namespace App\Controller;

use App\Entity\Peres;
use App\Form\PeresType;
use App\Data\SearchData;
use App\Form\SearchDataType;
use App\Data\SearchElevesData;
use App\Form\SearchElevesDataType;
use App\Repository\PeresRepository;
use App\Repository\ElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/peres')]
final class PeresController extends AbstractController
{
    #[Route(name: 'app_peres_index', methods: ['GET'])]
    public function index(Request $request, PeresRepository $peresRepository): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchDataType::class, $data);
        $form->handleRequest($request);
        $peres = $peresRepository->findBySearchData($data);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les résultats filtrés en utilisant le repository
            $peres = $peresRepository->findBySearchData($data);
        } else {
            // Récupérer tous les résultats si aucun critère de recherche n'est fourni
            $peres = $peresRepository->findAll();
        }

        return $this->render('peres/index.html.twig', [
            'peres' => $peres,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_peres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pere = new Peres();
        $form = $this->createForm(PeresType::class, $pere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pere);
            $entityManager->flush();

            return $this->redirectToRoute('app_peres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('peres/new.html.twig', [
            'pere' => $pere,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_peres_show', methods: ['GET'])]
    public function show(Peres $pere, ElevesRepository $elevesRepository, Request $request): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);

        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->leftjoin('e.parent', 'pa')  // Jointure avec LieuNaissance
            ->andWhere('pa.pere = :pere')   // Filtrer sur le nom de la commune
            ->setParameter('pere', $pere)
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
            'pere' => $pere,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_peres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Peres $pere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PeresType::class, $pere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_peres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('peres/edit.html.twig', [
            'pere' => $pere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_peres_delete', methods: ['POST'])]
    public function delete(Request $request, Peres $pere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pere->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_peres_index', [], Response::HTTP_SEE_OTHER);
    }
}
