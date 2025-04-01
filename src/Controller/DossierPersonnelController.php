<?php

namespace App\Controller;

use App\Entity\DossierPersonnel;
use App\Form\DossierPersonnelType;
use App\Repository\DossierPersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dossier/personnel')]
final class DossierPersonnelController extends AbstractController
{
    #[Route(name: 'app_dossier_personnel_index', methods: ['GET'])]
    public function index(DossierPersonnelRepository $dossierPersonnelRepository): Response
    {
        return $this->render('dossier_personnel/index.html.twig', [
            'dossier_personnels' => $dossierPersonnelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dossier_personnel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dossierPersonnel = new DossierPersonnel();
        $form = $this->createForm(DossierPersonnelType::class, $dossierPersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dossierPersonnel);
            $entityManager->flush();

            return $this->redirectToRoute('app_dossier_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dossier_personnel/new.html.twig', [
            'dossier_personnel' => $dossierPersonnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dossier_personnel_show', methods: ['GET'])]
    public function show(DossierPersonnel $dossierPersonnel): Response
    {
        return $this->render('dossier_personnel/show.html.twig', [
            'dossier_personnel' => $dossierPersonnel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dossier_personnel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DossierPersonnel $dossierPersonnel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DossierPersonnelType::class, $dossierPersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dossier_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dossier_personnel/edit.html.twig', [
            'dossier_personnel' => $dossierPersonnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dossier_personnel_delete', methods: ['POST'])]
    public function delete(Request $request, DossierPersonnel $dossierPersonnel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dossierPersonnel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($dossierPersonnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dossier_personnel_index', [], Response::HTTP_SEE_OTHER);
    }
}
