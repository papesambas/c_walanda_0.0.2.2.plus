<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Eleves;
use App\Entity\Statuts;
use App\Form\ElevesType;
use Psr\Log\LoggerInterface;
use App\Entity\DossierEleves;
use App\Data\SearchElevesData;
use App\Form\SearchElevesDataType;
use App\Repository\ElevesRepository;
use App\Repository\CerclesRepository;
use App\Repository\ClassesRepository;
use App\Repository\ParentsRepository;
use App\Repository\StatutsRepository;
use App\Service\RoleHierarchyService;
use App\Repository\CommunesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Scolarites1Repository;
use App\Repository\Scolarites2Repository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\LieuNaissancesRepository;
use App\Repository\Redoublements1Repository;
use App\Repository\Redoublements2Repository;
use App\Repository\Redoublements3Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/eleves')]
final class ElevesController extends AbstractController
{
    public function __construct(private Security $security, private LoggerInterface $logger)
    {
        $this->security = $security;
    }

    #[Route(name: 'app_eleves_index', methods: ['GET'])]
    public function index(Request $request, ElevesRepository $elevesRepository): Response
    {
        $data = new SearchElevesData();
        $form = $this->createForm(SearchElevesDataType::class, $data);
        $form->handleRequest($request);
        // Si le formulaire est soumis et valide, on effectue la recherche
        if ($form->isSubmitted() && $form->isValid()) {
            // Recherche des élèves selon les critères
            $eleves = $elevesRepository->findBySearchCriteria($data);
        } else {
            // Sinon on récupère tous les élèves
            $eleves = $elevesRepository->findAll();
        }

        return $this->render('eleves/index.html.twig', [
            'eleves' => $eleves,
            'form' => $form->createView(),  // Vue du formulaire pour filtrer les résultats
        ]);
    }

    #[Route('/new', name: 'app_eleves_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        ParentsRepository $parentsRepository,
        RoleHierarchyService $roleHierarchyService,
        RoleHierarchyInterface $roleHierarchy,
        SluggerInterface $slugger,
        UserPasswordHasherInterface $PasswordHasher,
    ): Response {
        $elefe = new Eleves();
        $user = $this->security->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté');
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        // Récupération des rôles hérités de l'utilisateur
        //$allUserRoles = $roleHierarchyService->getUserRolesWithHierarchy($roleHierarchy, $user);

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
        //dd($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $documents = $form->get('document')->getData();
                //$extrait = $form->get('extrait')->getData();
                foreach ($documents as $document) {
                    $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $document->guessExtension();
                    $fichier = md5(uniqid()) . '.' . $document->guessExtension();

                    //On copie le fichier dans le dossier upload
                    $document->move(
                        $this->getParameter('documents_eleves_directory'),
                        $originalFilename
                    );

                    //On stock le nom du document dans la base de donnée
                    $docum = new DossierEleves;
                    $docum->setDesignation($originalFilename);
                    $docum->setSlug($fichier);
                    $elefe->addDossierElefe($docum);
                }

                $suffix = substr(time(), -4);

                $user = new Users();
                $password = 'password';
                $email = "inscription@EMPT.edu";
                $userNom = $elefe->getNom();
                $userPrenom = $elefe->getPrenom();
                $userFullname = $elefe->getNom() . ' ' . $elefe->getPrenom();
                $username = $elefe->getNom() . ' ' . $elefe->getPrenom() . $suffix;
                $user->setEmail($email);
                $user->setFullname($userFullname);
                $user->setNom($userNom);
                $user->setPrenom($userPrenom);
                $user->setPassword($PasswordHasher->hashPassword($user, $password));
                $user->setUsername($username);
                $user->setRoles(['ROLE_ELEVE']);
                $entityManager->persist($user);
                $entityManager->flush();

                $elefe->setUsers($user);
                $user->setEleve($elefe);

                $entityManager->persist($elefe);
                $entityManager->flush();

                $this->addFlash('success', 'L\'élève a été créé avec succès.');
                return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                // Journalisation de l'erreur
                $this->addFlash('error', 'Une erreur s\'est produite lors de l\'enregistrement des modifications.');
                // Vous pouvez également logger l'erreur pour un débogage ultérieur
                $this->logger->error('Erreur lors de la modification de l\'élève : ' . $e->getMessage());
            }
        }

        return $this->render('eleves/new.html.twig', [
            'eleve' => $elefe,
            'form'  => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'app_eleves_show', methods: ['GET'])]
    public function show(Eleves $elefe): Response
    {
        return $this->render('eleves/show.html.twig', [
            'elefe' => $elefe,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_eleves_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Eleves $elefe,
        EntityManagerInterface $entityManager,
        ParentsRepository $parentsRepository,
        RoleHierarchyService $roleHierarchyService,
        RoleHierarchyInterface $roleHierarchy,
        SluggerInterface $slugger,
        UserPasswordHasherInterface $PasswordHasher
    ): Response {
        $user = $this->security->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté');
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        // Récupération des rôles hérités de l'utilisateur
        //$allUserRoles = $roleHierarchyService->getUserRolesWithHierarchy($roleHierarchy, $user);

        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //try {
            $documents = $form->get('document')->getData();
            //$extrait = $form->get('extrait')->getData();
            foreach ($documents as $document) {
                $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $document->guessExtension();
                $fichier = md5(uniqid()) . '.' . $document->guessExtension();

                //On copie le fichier dans le dossier upload
                $document->move(
                    $this->getParameter('documents_eleves_directory'),
                    $originalFilename
                );

                //On stock le nom du document dans la base de donnée
                $docum = new DossierEleves;
                $docum->setDesignation($originalFilename);
                $docum->setSlug($fichier);
                $elefe->addDossierElefe($docum);
            }

            $user = $elefe->getUsers();
            if (!$user) {
                $suffix = substr(time(), -4);

                $user = new Users();
                $password = 'password';
                $email = "inscription@EMPT.edu";
                $userNom = $elefe->getNom();
                $userPrenom = $elefe->getPrenom();
                $userFullname = $elefe->getNom() . ' ' . $elefe->getPrenom();
                $username = $elefe->getNom() . ' ' . $elefe->getPrenom() . $suffix;
                $user->setEmail($email);
                $user->setFullname($userFullname);
                $user->setNom($userNom);
                $user->setPrenom($userPrenom);
                $user->setPassword($PasswordHasher->hashPassword($user, $password));
                $user->setUsername($username);
                $user->setRoles(['ROLE_ELEVE']);
                $entityManager->persist($user);
                $entityManager->flush();

                $elefe->setUsers($user);
                $user->setEleve($elefe);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
            /*} catch (\Exception $e) {
                // Journalisation de l'erreur
                $this->addFlash('error', 'Une erreur s\'est produite lors de l\'enregistrement des modifications.');
                // Vous pouvez également logger l'erreur pour un débogage ultérieur
                // $this->logger->error('Erreur lors de la modification de l\'élève : ' . $e->getMessage());
            }*/
        }

        return $this->render('eleves/edit.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
            'age' => $elefe->getAge(),
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

    #[Route('/delete/document/{id}', name: 'app_eleve_documents_delete', methods: ['DELETE'])]
    public function deleteDocument(Request $request, DossierEleves $document, EntityManagerInterface $entityManager)
    {
        if (!$document) {
            return new JsonResponse(['success' => false, 'error' => 'Document introuvable'], 404);
        }

        $data = json_decode($request->getContent(), true);
        //On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $data['_token'])) {
            //On récupère le nom du document
            $designation = $document->getDesignation();
            //On supprime de la base
            $entityManager->remove($document);
            $entityManager->flush();

            //On supprime le fichier
            unlink($this->getParameter('documents_eleves_directory') . '/' . $designation);

            // On repond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => "Token Invalide"], 400);
        }
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

    #[Route('/redoublement1-by-scolarite2/{scolarite2Id}', name: 'redoublement1_by_scolarite2')]
    public function getRedoublement1ByScolarite2(int $scolarite2Id, Scolarites2Repository $scolarites2Repository, Redoublements1Repository $redoublements1Repository): JsonResponse
    {
        $scolarites2 = $scolarites2Repository->findOneBy(['id' => $scolarite2Id]);
        $scolarite1 = $scolarites2 ? $scolarites2->getScolarite1() : null;
        $redoublements1 = $redoublements1Repository->findByScolarites1AndScolarites2($scolarite1, $scolarites2);

        $html = '<option value="">Choisir un redoublement</option>';
        foreach ($redoublements1 as $redoublement1) {
            $html .= '<option value="' . $redoublement1->getId() . '">' . $redoublement1->getNiveau() . '</option>';
        }

        // Retourner une réponse JSON avec deux informations
        return new JsonResponse([
            'html' => $html,
            'has_redoublements' => !empty($redoublements1)
        ]);
    }

    #[Route('/redoublement2-by-redoublement1/{redoublement1Id}', name: 'redoublement2_by_redoublement1')]
    public function getRedoublement2ByRedoublement1(int $redoublement1Id, Redoublements2Repository $redoublements2Repository): JsonResponse
    {
        $redoublements2 = $redoublements2Repository->findBy(['redoublement1' => $redoublement1Id]);

        $html = '<option value="">Choisir un redoublement</option>';
        foreach ($redoublements2 as $redoublement2) {
            $html .= '<option value="' . $redoublement2->getId() . '">' . $redoublement2->getNiveau() . '</option>';
        }

        return new JsonResponse([
            'html' => $html,
            'has_redoublement2s' => !empty($redoublements2)
        ]);
    }

    #[Route('/redoublement3-by-redoublement2/{redoublement2Id}', name: 'redoublement3_by_redoublement2')]
    public function getRedoublement3ByRedoublement2(int $redoublement2Id, Redoublements3Repository $redoublements3Repository): JsonResponse
    {
        $redoublements3 = $redoublements3Repository->findBy(['redoublement2' => $redoublement2Id]);

        $html = '<option value="">Choisir un redoublement</option>';
        foreach ($redoublements3 as $redoublement3) {
            $html .= '<option value="' . $redoublement3->getId() . '">' . $redoublement3->getNiveau() . '</option>';
        }

        return new JsonResponse([
            'html' => $html,
            'has_redoublement3s' => !empty($redoublements3)
        ]);
    }
}
