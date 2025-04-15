<?php

namespace App\Controller;

use App\Entity\NiveauEtudes;
use App\Form\NiveauEtudesType;
use App\Repository\NiveauEtudesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/niveau/etudes')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class NiveauEtudesController extends AbstractController
{
    #[Route(name: 'app_niveau_etudes_index', methods: ['GET'])]
    public function index(NiveauEtudesRepository $niveauEtudesRepository): Response
    {
        return $this->render('niveau_etudes/index.html.twig', [
            'niveau_etudes' => $niveauEtudesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_niveau_etudes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $niveauEtude = new NiveauEtudes();
        $form = $this->createForm(NiveauEtudesType::class, $niveauEtude);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niveauEtude);
            $entityManager->flush();

            return $this->redirectToRoute('app_niveau_etudes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('niveau_etudes/new.html.twig', [
            'niveau_etude' => $niveauEtude,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_niveau_etudes_show', methods: ['GET'])]
    public function show(NiveauEtudes $niveauEtude): Response
    {
        return $this->render('niveau_etudes/show.html.twig', [
            'niveau_etude' => $niveauEtude,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_niveau_etudes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NiveauEtudes $niveauEtude, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NiveauEtudesType::class, $niveauEtude);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_niveau_etudes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('niveau_etudes/edit.html.twig', [
            'niveau_etude' => $niveauEtude,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_niveau_etudes_delete', methods: ['POST'])]
    public function delete(Request $request, NiveauEtudes $niveauEtude, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niveauEtude->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($niveauEtude);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_niveau_etudes_index', [], Response::HTTP_SEE_OTHER);
    }
}
