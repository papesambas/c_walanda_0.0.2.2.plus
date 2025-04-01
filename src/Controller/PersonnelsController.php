<?php

namespace App\Controller;

use App\Entity\Personnels;
use App\Form\PersonnelsType;
use App\Repository\PersonnelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/personnels')]
final class PersonnelsController extends AbstractController
{
    #[Route(name: 'app_personnels_index', methods: ['GET'])]
    public function index(PersonnelsRepository $personnelsRepository): Response
    {
        return $this->render('personnels/index.html.twig', [
            'personnels' => $personnelsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_personnels_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $personnel = new Personnels();
        $form = $this->createForm(PersonnelsType::class, $personnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($personnel);
            $entityManager->flush();

            return $this->redirectToRoute('app_personnels_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('personnels/new.html.twig', [
            'personnel' => $personnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personnels_show', methods: ['GET'])]
    public function show(Personnels $personnel): Response
    {
        return $this->render('personnels/show.html.twig', [
            'personnel' => $personnel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_personnels_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Personnels $personnel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PersonnelsType::class, $personnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_personnels_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('personnels/edit.html.twig', [
            'personnel' => $personnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personnels_delete', methods: ['POST'])]
    public function delete(Request $request, Personnels $personnel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personnel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($personnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_personnels_index', [], Response::HTTP_SEE_OTHER);
    }
}
