<?php

namespace App\Controller;

use App\Entity\IndisciplinePersonnel;
use App\Form\IndisciplinePersonnelType;
use App\Repository\IndisciplinePersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;    

#[Route('/indiscipline/personnel')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class IndisciplinePersonnelController extends AbstractController
{
    #[Route(name: 'app_indiscipline_personnel_index', methods: ['GET'])]
    public function index(IndisciplinePersonnelRepository $indisciplinePersonnelRepository): Response
    {
        return $this->render('indiscipline_personnel/index.html.twig', [
            'indiscipline_personnels' => $indisciplinePersonnelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_indiscipline_personnel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $indisciplinePersonnel = new IndisciplinePersonnel();
        $form = $this->createForm(IndisciplinePersonnelType::class, $indisciplinePersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($indisciplinePersonnel);
            $entityManager->flush();

            return $this->redirectToRoute('app_indiscipline_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('indiscipline_personnel/new.html.twig', [
            'indiscipline_personnel' => $indisciplinePersonnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_indiscipline_personnel_show', methods: ['GET'])]
    public function show(IndisciplinePersonnel $indisciplinePersonnel): Response
    {
        return $this->render('indiscipline_personnel/show.html.twig', [
            'indiscipline_personnel' => $indisciplinePersonnel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_indiscipline_personnel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, IndisciplinePersonnel $indisciplinePersonnel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IndisciplinePersonnelType::class, $indisciplinePersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_indiscipline_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('indiscipline_personnel/edit.html.twig', [
            'indiscipline_personnel' => $indisciplinePersonnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_indiscipline_personnel_delete', methods: ['POST'])]
    public function delete(Request $request, IndisciplinePersonnel $indisciplinePersonnel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$indisciplinePersonnel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($indisciplinePersonnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_indiscipline_personnel_index', [], Response::HTTP_SEE_OTHER);
    }
}
