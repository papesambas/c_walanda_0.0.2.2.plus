<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Form\ElevesType;
use App\Repository\ElevesRepository;
use App\Repository\CerclesRepository;
use App\Repository\ParentsRepository;
use App\Repository\CommunesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LieuNaissancesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/eleves')]
final class ElevesController extends AbstractController
{
    #[Route(name: 'app_eleves_index', methods: ['GET'])]
    public function index(ElevesRepository $elevesRepository): Response
    {
        return $this->render('eleves/index.html.twig', [
            'eleves' => $elevesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_eleves_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        ParentsRepository $parentsRepository
    ): Response {
        $elefe = new Eleves();

        // Vérifier si un parent est passé en paramètre
        if (!$request->query->has('parent_id')) {
            $this->addFlash('error', 'Un parent doit être associé à l\'élève. Veuillez d\'abord créer ou sélectionner un parent.');
            return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
        }

        // Pré-remplissage si un ID de parent est transmis
        $parent = $parentsRepository->find($request->query->get('parent_id'));
        if ($parent) {
            $elefe->setParent($parent);
        } else {
            $this->addFlash('error', 'Le parent spécifié n\'existe pas.');
            return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$entityManager->persist($elefe);
            //$entityManager->flush();

            $this->addFlash('success', 'L\'élève a été créé avec succès.');
            //return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleves/new.html.twig', [
            'eleve' => $elefe,
            'form'  => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_eleves_show', methods: ['GET'])]
    public function show(Eleves $elefe): Response
    {
        return $this->render('eleves/show.html.twig', [
            'elefe' => $elefe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eleves_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eleves $elefe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleves/edit.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eleves_delete', methods: ['POST'])]
    public function delete(Request $request, Eleves $elefe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $elefe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($elefe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/cercles-by-region/{regionId}', name: 'cercles_by_region')]
    public function getCerclesByRegion(int $regionId, CerclesRepository $cerclesRepository): Response
    {
        $cercles = $cerclesRepository->findBy(['region' => $regionId]);
        $html = '<option value="">Choisir un cercle</option>';
        foreach ($cercles as $cercle) {
            $html .= '<option value="' . $cercle->getId() . '">' . $cercle->getDesignation() . '</option>';
        }
        return new Response($html);
    }

    #[Route('/communes-by-cercle/{cercleId}', name: 'communes_by_cercle')]
    public function getCommunesByCercle(int $cercleId, CommunesRepository $communesRepository): Response
    {
        $communes = $communesRepository->findBy(['cercle' => $cercleId]);
        $html = '<option value="">Choisir une commune</option>';
        foreach ($communes as $commune) {
            $html .= '<option value="' . $commune->getId() . '">' . $commune->getDesignation() . '</option>';
        }
        return new Response($html);
    }

    #[Route('/lieux-by-commune/{communeId}', name: 'lieux_by_commune')]
    public function getLieuxByCommune(int $communeId, LieuNaissancesRepository $lieuNaissancesRepository): Response
    {
        $lieux = $lieuNaissancesRepository->findBy(['commune' => $communeId]);
        $html = '<option value="">Choisir un lieu de naissance</option>';
        foreach ($lieux as $lieu) {
            $html .= '<option value="' . $lieu->getId() . '">' . $lieu->getDesignation() . '</option>';
        }
        return new Response($html);
    }
}
