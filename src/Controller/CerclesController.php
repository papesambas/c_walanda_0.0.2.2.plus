<?php

namespace App\Controller;

use App\Entity\Cercles;
use App\Entity\Statuts;
use App\Form\CerclesType;
use App\Data\SearchElevesData;
use App\Form\SearchElevesDataType;
use App\Repository\ElevesRepository;
use App\Repository\CerclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/cercles')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CerclesController extends AbstractController
{
    #[Route(name: 'app_cercles_index', methods: ['GET'])]
    public function index(CerclesRepository $cerclesRepository): Response
    {
        return $this->render('cercles/index.html.twig', [
            'cercles' => $cerclesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cercles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cercle = new Cercles();
        $form = $this->createForm(CerclesType::class, $cercle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cercle);
            $entityManager->flush();

            return $this->redirectToRoute('app_cercles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cercles/new.html.twig', [
            'cercle' => $cercle,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_cercles_show', methods: ['GET'])]
    public function show(Request $request ,ElevesRepository $elevesRepository, Cercles $cercle): Response
    {
        // Création de l'objet de recherche
        $searchData = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $searchData);
        $form->handleRequest($request);
    
        // Requête de base filtrée par lieu de naissance
        $queryBuilder = $elevesRepository->createQueryBuilder('e')
            ->leftjoin('e.lieuNaissance', 'ln')  // Jointure avec LieuNaissance
            ->leftjoin('ln.commune', 'co')        // Jointure avec Commune
            ->andWhere('co.cercle = :cercle')   // Filtrer sur le nom de la commune
            ->setParameter('cercle', $cercle)
            ->orderBy('e.fullname', 'ASC');
    
        // Application des filtres supplémentaires si formulaire soumis
        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($searchData->q)) {
                $queryBuilder->andWhere('e.fullname LIKE :q')
                    ->setParameter('q', '%' . $searchData->q . '%');
            }
    
            if ($searchData->age1 !== null) {
                $queryBuilder->andWhere('e.age >= :age1')
                    ->setParameter('age1', $searchData->age1);
            }
    
            if ($searchData->age2 !== null) {
                $queryBuilder->andWhere('e.age <= :age2')
                    ->setParameter('age2', $searchData->age2);
            }
    
            if (!$searchData->statut->isEmpty()) {
                $designations = $searchData->statut->map(function ($statut) {
                    return $statut->getDesignation();
                })->toArray();
    
                $queryBuilder
                    ->leftJoin('e.statut', 's')
                    ->andWhere('s.designation IN (:statuts)')
                    ->setParameter('statuts', $designations);
            }
    
            if (!$searchData->classe->isEmpty()) {
                $queryBuilder->andWhere('e.classe IN (:classes)')
                    ->setParameter('classes', $searchData->classe);
            }
        }
    
        // Exécution de la requête
        $eleves = $queryBuilder
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    
        return $this->render('eleves/index.html.twig', [
            'eleves' => $eleves,
            'cercle' => $cercle,
            'form' => $form->createView()
        ]);

    }



    #[Route('/{slug}/edit', name: 'app_cercles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cercles $cercle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CerclesType::class, $cercle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cercles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cercles/edit.html.twig', [
            'cercle' => $cercle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cercles_delete', methods: ['POST'])]
    public function delete(Request $request, Cercles $cercle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cercle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cercle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cercles_index', [], Response::HTTP_SEE_OTHER);
    }
}
