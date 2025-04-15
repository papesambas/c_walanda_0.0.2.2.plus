<?php

namespace App\Controller;

use App\Entity\Contrats;
use App\Form\ContratsType;
use App\Repository\ContratsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;    

#[Route('/contrats')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class ContratsController extends AbstractController
{
    #[Route(name: 'app_contrats_index', methods: ['GET'])]
    public function index(ContratsRepository $contratsRepository): Response
    {
        return $this->render('contrats/index.html.twig', [
            'contrats' => $contratsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contrats_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contrat = new Contrats();
        $form = $this->createForm(ContratsType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contrat);
            $entityManager->flush();

            return $this->redirectToRoute('app_contrats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrats/new.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrats_show', methods: ['GET'])]
    public function show(Contrats $contrat): Response
    {
        return $this->render('contrats/show.html.twig', [
            'contrat' => $contrat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrats_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contrats $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratsType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contrats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrats/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrats_delete', methods: ['POST'])]
    public function delete(Request $request, Contrats $contrat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($contrat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contrats_index', [], Response::HTTP_SEE_OTHER);
    }
}
