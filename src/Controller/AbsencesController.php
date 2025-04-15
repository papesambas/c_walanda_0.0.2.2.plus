<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Entity\Absences;
use App\Form\AbsencesType;
use App\Repository\AbsencesRepository;
use App\Repository\AnneeScolairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



#[Route('/absences')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class AbsencesController extends AbstractController
{
    #[Route(name: 'app_absences_index', methods: ['GET'])]
    public function index(AbsencesRepository $absencesRepository): Response
    {
        return $this->render('absences/index.html.twig', [
            'absences' => $absencesRepository->findAll(),
        ]);
    }

    #[Route('{slug}/new', name: 'app_absences_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Eleves $eleves,AnneeScolairesRepository $anneeScolairesRepository,AbsencesRepository $absencesRepo): Response
    {
        $absence = new Absences();
        $annee = $anneeScolairesRepository->findCurrentYear();
        $current = new \DateTimeImmutable();
        $currentDay = $current->setTime(0, 0, 0); // Date du jour à minuit
        $currentTimeString = $current->format('H:i');

        $absence 
        ->setAnneeScolaire($annee)
        ->setHeure($current)
        ->setJour($currentDay)
        ->setEleve($eleves);

        $form = $this->createForm(AbsencesType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($absence->getHeure() && $absencesRepo->findExistingAbsence(
                $absence->getEleve(),
                $absence->getJour(),
                $absence->getAnneeScolaire()
            )) {
                $this->addFlash('error', 'Une absence existe déjà pour cet élève aujourdhui.');
                return $this->redirectToRoute('app_retards_eleves');
            }
            $entityManager->persist($absence);
            $entityManager->flush();

            return $this->redirectToRoute('app_absences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absences/new.html.twig', [
            'absence' => $absence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absences_show', methods: ['GET'])]
    public function show(Absences $absence): Response
    {
        return $this->render('absences/show.html.twig', [
            'absence' => $absence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_absences_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Absences $absence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AbsencesType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_absences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absences/edit.html.twig', [
            'absence' => $absence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absences_delete', methods: ['POST'])]
    public function delete(Request $request, Absences $absence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($absence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_absences_index', [], Response::HTTP_SEE_OTHER);
    }
}
