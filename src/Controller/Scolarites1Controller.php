<?php

namespace App\Controller;

use App\Entity\Scolarites1;
use App\Form\Scolarites1Type;
use App\Repository\Scolarites1Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/scolarites1')]
final class Scolarites1Controller extends AbstractController
{
    #[Route(name: 'app_scolarites1_index', methods: ['GET'])]
    public function index(Scolarites1Repository $scolarites1Repository): Response
    {
        return $this->render('scolarites1/index.html.twig', [
            'scolarites1s' => $scolarites1Repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scolarites1_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scolarites1 = new Scolarites1();
        $form = $this->createForm(Scolarites1Type::class, $scolarites1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scolarites1);
            $entityManager->flush();

            return $this->redirectToRoute('app_scolarites1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scolarites1/new.html.twig', [
            'scolarites1' => $scolarites1,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scolarites1_show', methods: ['GET'])]
    public function show(Scolarites1 $scolarites1): Response
    {
        return $this->render('scolarites1/show.html.twig', [
            'scolarites1' => $scolarites1,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scolarites1_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scolarites1 $scolarites1, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Scolarites1Type::class, $scolarites1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scolarites1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scolarites1/edit.html.twig', [
            'scolarites1' => $scolarites1,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scolarites1_delete', methods: ['POST'])]
    public function delete(Request $request, Scolarites1 $scolarites1, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scolarites1->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scolarites1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scolarites1_index', [], Response::HTTP_SEE_OTHER);
    }
}
