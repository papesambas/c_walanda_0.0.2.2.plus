<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Form\ParentsType;
use App\Data\SearchElevesData;
use App\Data\SearchParentData;
use App\Form\SearchElevesDataType;
use App\Form\SearchParentDataType;
use App\Repository\MeresRepository;
use App\Repository\PeresRepository;
use App\Repository\ElevesRepository;
use App\Repository\ParentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/parents')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class ParentsController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route(name: 'app_parents_index', methods: ['GET'])]
    public function index(
        Request $request,
        ParentsRepository $parentsRepository,
        PeresRepository $peresRepository,
        MeresRepository $meresRepository
    ): Response {
        $data = new SearchParentData();
        $form = $this->createForm(SearchParentDataType::class, $data);
        $form->handleRequest($request);

        // Recherche des pères et mères correspondants
        $peres = $peresRepository->findBySearchParentData($data);
        $meres = $meresRepository->findBySearchParentData($data);

        if ($form->isSubmitted() && $form->isValid() && (!empty($peres) || !empty($meres))) {
            // Recherche des parents correspondants avec tous les pères et mères trouvés
            $parents = $parentsRepository->findByPereOrMere($peres, $meres);
        } else {
            // Si aucun critère de recherche, affichez tous les parents
            $parents = $parentsRepository->findAll();
        }

        return $this->render('parents/index.html.twig', [
            'parents' => $parents,
            'form'    => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_SECRETAIRE')]
    #[Route('/inscription', name: 'app_parents_inscription', methods: ['GET'])]
    public function inscription(
        Request $request,
        PeresRepository $peresRepository,
        MeresRepository $meresRepository,
        ParentsRepository $parentsRepository
    ): Response {
        $data = new SearchParentData();
        $form = $this->createForm(SearchParentDataType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Recherche pour le père
            $peres = $peresRepository->findBySearchParentDataForInscription($data);
            // Recherche pour la mère
            $meres = $meresRepository->findBySearchParentDataForInscription($data);

            if (!empty($peres) && !empty($meres)) {
                // Rechercher un parent existant avec le père et la mère
                $parent = $parentsRepository->findOneByPereAndMere($peres, $meres);
                if ($parent) {
                    // Rediriger vers la création d'un élève avec l'ID du parent
                    //return $this->redirectToRoute('app_eleves_new', [
                    return $this->redirectToRoute('app_eleves_new', [
                        'parent_id' => $parent->getId(),
                    ], Response::HTTP_SEE_OTHER);
                } else {
                    // Aucun parent trouvé, rediriger vers la création d'un parent avec père et mère pré-remplis
                    return $this->redirectToRoute('app_parents_new', [
                        'pere_id' => $peres[0]->getId(),
                        'mere_id' => $meres[0]->getId(),
                    ], Response::HTTP_SEE_OTHER);
                }
            } elseif (!empty($peres) && empty($meres)) {
                // Rediriger vers la création d'un nouveau parent avec le père pré-rempli
                return $this->redirectToRoute('app_parents_new', [
                    'pere_id' => $peres[0]->getId(),
                ], Response::HTTP_SEE_OTHER);
            } elseif (empty($peres) && !empty($meres)) {
                // Rediriger vers la création d'un nouveau parent avec la mère pré-remplie
                return $this->redirectToRoute('app_parents_new', [
                    'mere_id' => $meres[0]->getId(),
                ], Response::HTTP_SEE_OTHER);
            } else {
                // Aucun résultat pour père et mère, rediriger vers la création d'un parent
                $this->addFlash('warning', 'Aucun parent trouvé. Veuillez d\'abord créer un parent.');
                return $this->redirectToRoute('app_parents_new', [], Response::HTTP_SEE_OTHER);
            }
        }

        // Aucun critère de recherche, on affiche tous les parents (ou le formulaire)
        $parents = $parentsRepository->findAll();

        return $this->render('parents/index.html.twig', [
            'parents' => $parents,
            'form'    => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_SECRETAIRE')]
    #[Route('/new', name: 'app_parents_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        PeresRepository $peresRepository,
        MeresRepository $meresRepository
    ): Response {
        $parent = new Parents();

        // Pré-remplissage si un ID de père est transmis
        if ($request->query->has('pere_id')) {
            $pere = $peresRepository->find($request->query->get('pere_id'));
            if ($pere) {
                $parent->setPere($pere);
            } else {
                $this->addFlash('error', 'Le père spécifié n\'existe pas.');
                return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        // Pré-remplissage si un ID de mère est transmis
        if ($request->query->has('mere_id')) {
            $mere = $meresRepository->find($request->query->get('mere_id'));
            if ($mere) {
                $parent->setMere($mere);
            } else {
                $this->addFlash('error', 'La mère spécifiée n\'existe pas.');
                return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        $form = $this->createForm(ParentsType::class, $parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parent);
            $entityManager->flush();

            $this->addFlash('success', 'Le parent a été créé avec succès.');
            return $this->redirectToRoute('app_eleves_new', [
                'parent_id' => $parent->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parents/new.html.twig', [
            'parent' => $parent,
            'form'   => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{slug}', name: 'app_parents_show', methods: ['GET'])]
    public function show(Parents $parent, ElevesRepository $elevesRepository,Request $request): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);

        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->andWhere('e.parent = :parent')
            ->setParameter('parent', $parent)
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
            'parent' => $parent,
            'form' => $form->createView()
        ]);
    }

    #[IsGranted('ROLE_DIRECTION')]
    #[Route('/{slug}/edit', name: 'app_parents_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parents $parent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParentsType::class, $parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parents/edit.html.twig', [
            'parent' => $parent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parents_delete', methods: ['POST'])]
    public function delete(Request $request, Parents $parent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $parent->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
    }
}
