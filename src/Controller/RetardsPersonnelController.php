<?php

namespace App\Controller;

use App\Entity\RetardsPersonnel;
use App\Form\RetardsPersonnelType;
use App\Repository\RetardsPersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/retards/personnel')]
final class RetardsPersonnelController extends AbstractController
{
    #[Route(name: 'app_retards_personnel_index', methods: ['GET'])]
    public function index(RetardsPersonnelRepository $retardsPersonnelRepository): Response
    {
        return $this->render('retards_personnel/index.html.twig', [
            'retards_personnels' => $retardsPersonnelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_retards_personnel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $retardsPersonnel = new RetardsPersonnel();
        $form = $this->createForm(RetardsPersonnelType::class, $retardsPersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($retardsPersonnel);
            $entityManager->flush();

            return $this->redirectToRoute('app_retards_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('retards_personnel/new.html.twig', [
            'retards_personnel' => $retardsPersonnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_retards_personnel_show', methods: ['GET'])]
    public function show(RetardsPersonnel $retardsPersonnel): Response
    {
        return $this->render('retards_personnel/show.html.twig', [
            'retards_personnel' => $retardsPersonnel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_retards_personnel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RetardsPersonnel $retardsPersonnel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RetardsPersonnelType::class, $retardsPersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_retards_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('retards_personnel/edit.html.twig', [
            'retards_personnel' => $retardsPersonnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_retards_personnel_delete', methods: ['POST'])]
    public function delete(Request $request, RetardsPersonnel $retardsPersonnel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$retardsPersonnel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($retardsPersonnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_retards_personnel_index', [], Response::HTTP_SEE_OTHER);
    }
}
