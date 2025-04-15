<?php

namespace App\Controller;

use App\Entity\Scolarites2;
use App\Form\Scolarites2Type;
use App\Repository\Scolarites2Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/scolarites2')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class Scolarites2Controller extends AbstractController
{
    #[Route(name: 'app_scolarites2_index', methods: ['GET'])]
    public function index(Scolarites2Repository $scolarites2Repository): Response
    {
        return $this->render('scolarites2/index.html.twig', [
            'scolarites2s' => $scolarites2Repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scolarites2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scolarites2 = new Scolarites2();
        $form = $this->createForm(Scolarites2Type::class, $scolarites2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scolarites2);
            $entityManager->flush();

            return $this->redirectToRoute('app_scolarites2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scolarites2/new.html.twig', [
            'scolarites2' => $scolarites2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scolarites2_show', methods: ['GET'])]
    public function show(Scolarites2 $scolarites2): Response
    {
        return $this->render('scolarites2/show.html.twig', [
            'scolarites2' => $scolarites2,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_scolarites2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scolarites2 $scolarites2, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Scolarites2Type::class, $scolarites2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scolarites2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scolarites2/edit.html.twig', [
            'scolarites2' => $scolarites2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scolarites2_delete', methods: ['POST'])]
    public function delete(Request $request, Scolarites2 $scolarites2, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scolarites2->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scolarites2);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scolarites2_index', [], Response::HTTP_SEE_OTHER);
    }
}
