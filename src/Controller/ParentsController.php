<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Form\ParentsType;
use App\Data\SearchParentData;
use App\Form\SearchParentDataType;
use App\Repository\MeresRepository;
use App\Repository\PeresRepository;
use App\Repository\ParentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/parents')]
final class ParentsController extends AbstractController
{
    #[Route(name: 'app_parents_index', methods: ['GET'])]
    public function index(
        Request $request, ParentsRepository $parentsRepository, PeresRepository $peresRepository, MeresRepository $meresRepository
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

    #[Route('/new', name: 'app_parents_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,
        PeresRepository $peresRepository, MeresRepository $meresRepository
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

    #[Route('/{id}', name: 'app_parents_show', methods: ['GET'])]
    public function show(Parents $parent): Response
    {
        return $this->render('parents/show.html.twig', [
            'parent' => $parent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parents_edit', methods: ['GET', 'POST'])]
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
        if ($this->isCsrfTokenValid('delete'.$parent->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
    }
}
