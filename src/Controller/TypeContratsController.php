<?php

namespace App\Controller;

use App\Entity\TypeContrats;
use App\Form\TypeContratsType;
use App\Repository\TypeContratsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/contrats')]
final class TypeContratsController extends AbstractController
{
    #[Route(name: 'app_type_contrats_index', methods: ['GET'])]
    public function index(TypeContratsRepository $typeContratsRepository): Response
    {
        return $this->render('type_contrats/index.html.twig', [
            'type_contrats' => $typeContratsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_contrats_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeContrat = new TypeContrats();
        $form = $this->createForm(TypeContratsType::class, $typeContrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeContrat);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_contrats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_contrats/new.html.twig', [
            'type_contrat' => $typeContrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_contrats_show', methods: ['GET'])]
    public function show(TypeContrats $typeContrat): Response
    {
        return $this->render('type_contrats/show.html.twig', [
            'type_contrat' => $typeContrat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_contrats_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeContrats $typeContrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeContratsType::class, $typeContrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_contrats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_contrats/edit.html.twig', [
            'type_contrat' => $typeContrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_contrats_delete', methods: ['POST'])]
    public function delete(Request $request, TypeContrats $typeContrat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeContrat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeContrat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_contrats_index', [], Response::HTTP_SEE_OTHER);
    }
}
