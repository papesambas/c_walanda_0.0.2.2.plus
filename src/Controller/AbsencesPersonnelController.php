<?php

namespace App\Controller;

use App\Entity\AbsencesPersonnel;
use App\Form\AbsencesPersonnelType;
use App\Repository\AbsencesPersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/absences/personnel')]
final class AbsencesPersonnelController extends AbstractController
{
    #[Route(name: 'app_absences_personnel_index', methods: ['GET'])]
    public function index(AbsencesPersonnelRepository $absencesPersonnelRepository): Response
    {
        return $this->render('absences_personnel/index.html.twig', [
            'absences_personnels' => $absencesPersonnelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_absences_personnel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $absencesPersonnel = new AbsencesPersonnel();
        $form = $this->createForm(AbsencesPersonnelType::class, $absencesPersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($absencesPersonnel);
            $entityManager->flush();

            return $this->redirectToRoute('app_absences_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absences_personnel/new.html.twig', [
            'absences_personnel' => $absencesPersonnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absences_personnel_show', methods: ['GET'])]
    public function show(AbsencesPersonnel $absencesPersonnel): Response
    {
        return $this->render('absences_personnel/show.html.twig', [
            'absences_personnel' => $absencesPersonnel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_absences_personnel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AbsencesPersonnel $absencesPersonnel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AbsencesPersonnelType::class, $absencesPersonnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_absences_personnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absences_personnel/edit.html.twig', [
            'absences_personnel' => $absencesPersonnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absences_personnel_delete', methods: ['POST'])]
    public function delete(Request $request, AbsencesPersonnel $absencesPersonnel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$absencesPersonnel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($absencesPersonnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_absences_personnel_index', [], Response::HTTP_SEE_OTHER);
    }
}
