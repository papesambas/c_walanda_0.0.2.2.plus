<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Form\ElevesType;
use App\Repository\ElevesRepository;
use App\Repository\CerclesRepository;
use App\Repository\ClassesRepository;
use App\Repository\NiveauxRepository;
use App\Repository\ParentsRepository;
use App\Repository\StatutsRepository;
use App\Repository\CommunesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Scolarites1Repository;
use App\Repository\Scolarites2Repository;
use App\Service\DateConfigurationService;
use App\Repository\LieuNaissancesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/classes-by-niveau/{niveauId}', name: 'classes_by_niveau')]
    public function getClassesByNiveau(int $niveauId, ClassesRepository $classesRepository): Response
    {
        $classes = $classesRepository->findBy(['niveau' => $niveauId]);
        $html = '<option value="">Choisir une classe</option>';
        foreach ($classes as $classe) {
            $html .= '<option value="' . $classe->getId() . '">' . $classe->getDesignation() . '</option>';
        }
        return new Response($html);
    }

    #[Route('/statuts-by-niveau/{niveauId}', name: 'statuts_by_niveau')]
    public function getStatutsByNiveau(int $niveauId, StatutsRepository $statutsRepository): Response
    {
        $statuts = $statutsRepository->findByNiveau($niveauId);
        dump($statuts);
        $html = '<option value="">Choisir un niveau</option>';
        foreach ($statuts as $statut) {
            $html .= '<option value="' . $statut->getId() . '">' . $statut->getDesignation() . '</option>';
        }
        return new Response($html);
    }

    #[Route('/scolarites1-by-niveau/{niveauId}', name: 'scolarites1_by_niveau')]
    public function getScolarites1ByNiveau(int $niveauId, Scolarites1Repository $scolarites1Repository): Response
    {
        $scolarites1 = $scolarites1Repository->findBy(['niveau' => $niveauId]);
        $html = '<option value="">Choisir un niveau</option>';
        foreach ($scolarites1 as $scolarite1) {
            $html .= '<option value="' . $scolarite1->getId() . '">' . $scolarite1->getScolarite() . '</option>';
        }
        return new Response($html);
    }

    #[Route('/scolarites2-by-scolarite1/{scolarite1Id}', name: 'scolarites2_by_scolarite1')]
    public function getScolarites2ByScolarite1(int $scolarite1Id, Scolarites2Repository $scolarites2Repository): Response
    {
        $scolarites2 = $scolarites2Repository->findBy(['scolarite1' => $scolarite1Id]);
        $html = '<option value="">Choisir une scolarité</option>';
        foreach ($scolarites2 as $scolarite2) {
            $html .= '<option value="' . $scolarite2->getId() . '">' . $scolarite2->getScolarite() . '</option>';
        }
        return new Response($html);
    }


    /*#[Route('/dates-by-niveau/{id}', name: 'eleves_dates_by_niveau', methods: ['GET'])]
    public function getDatesByNiveau(NiveauxRepository $niveauxRepository, int $id, DateConfigurationService $dateService): JsonResponse
    {
        $niveaux = $niveauxRepository->find($id);

        if (!$niveaux) {
            return new JsonResponse(['error' => 'Niveau non trouvé'], 404);
        }

        $designation = $niveaux->getDesignation();
        $configurations = $dateService->getDateConfigurations();

        return new JsonResponse($configurations[$designation] ?? []);
    }*/
}
