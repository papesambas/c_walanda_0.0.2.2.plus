<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Entity\Indiscipline;
use App\Form\IndisciplineType;
use App\Repository\AnneeScolairesRepository;
use App\Repository\IndisciplineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/indiscipline')]
final class IndisciplineController extends AbstractController
{
    #[Route(name: 'app_indiscipline_index', methods: ['GET'])]
    public function index(IndisciplineRepository $indisciplineRepository): Response
    {
        return $this->render('indiscipline/index.html.twig', [
            'indisciplines' => $indisciplineRepository->findAll(),
        ]);
    }

    #[Route('{slug}/new', name: 'app_indiscipline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,
    Eleves $eleves,AnneeScolairesRepository $anneeScolairesRepository,
    IndisciplineRepository $indisciplineRepo): Response
    {
        $indiscipline = new Indiscipline();
        $annee = $anneeScolairesRepository->findCurrentYear();
        $current = new \DateTimeImmutable();
        $currentDay = $current->setTime(0, 0, 0); // Date du jour à minuit
        $currentTimeString = $current->format('H:i');

        $indiscipline 
        ->setAnneeScolaire($annee)
        ->setJour($currentDay)
        ->setEleve($eleves);

        $form = $this->createForm(IndisciplineType::class, $indiscipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($indisciplineRepo->findExistingIndiscipline(
                $indiscipline->getEleve(),
                $indiscipline->getJour(),
                $indiscipline->getAnneeScolaire()
            )) {
                $this->addFlash('error', 'Un cas est déjà signalé pour cet élève aujourdhui.');
                return $this->redirectToRoute('app_retards_eleves');
            }

            $entityManager->persist($indiscipline);
            $entityManager->flush();

            return $this->redirectToRoute('app_indiscipline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('indiscipline/new.html.twig', [
            'indiscipline' => $indiscipline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_indiscipline_show', methods: ['GET'])]
    public function show(Indiscipline $indiscipline): Response
    {
        return $this->render('indiscipline/show.html.twig', [
            'indiscipline' => $indiscipline,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_indiscipline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Indiscipline $indiscipline, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IndisciplineType::class, $indiscipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_indiscipline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('indiscipline/edit.html.twig', [
            'indiscipline' => $indiscipline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_indiscipline_delete', methods: ['POST'])]
    public function delete(Request $request, Indiscipline $indiscipline, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$indiscipline->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($indiscipline);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_indiscipline_index', [], Response::HTTP_SEE_OTHER);
    }
}
