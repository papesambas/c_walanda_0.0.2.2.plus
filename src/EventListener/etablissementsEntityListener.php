<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Users;
use App\Entity\Cycles;
use App\Entity\Classes;
use App\Entity\Niveaux;
use App\Entity\Statuts;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use App\Entity\Etablissements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class etablissementsEntityListener // Renommez la classe en PascalCase
{
    private $security;
    private $slugger;
    private $passwordHasher;
    private $entityManager;

    public function __construct(
        Security $security,
        SluggerInterface $slugger,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ) {
        $this->security = $security;
        $this->slugger = $slugger;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public function prePersist(Etablissements $etablissements, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();

        if ($user === null) {
            $etablissements
                ->setCreatedAt(new \DateTimeImmutable('now'))
                ->setSlug($this->getClassesSlug($etablissements));
        } else {
            $etablissements
                ->setCreatedAt(new \DateTimeImmutable('now'))
                ->setCreatedBy($user)
                ->setSlug($this->getClassesSlug($etablissements));
        }

        // Création des utilisateurs
        $this->createDefaultUsers($etablissements);

        // Création des éléments pédagogiques
        $this->createDefaultCyclesNiveauxClasses($etablissements);
    }

    private function createDefaultUsers(Etablissements $etablissements): void
    {
        $usersToCreate = [
            [
                'nom' => 'super administrateur',
                'prenom' => 'super administrateur',
                'username' => $this->generateUniqueUsername('superadmin', $etablissements),
                'email' => 'superadmin@' . $etablissements->getSlug() . '.com',
                'roles' => ['ROLE_SUPERADMIN'],
                'password' => 'superadmin'
            ],
            [
                'nom' => 'promoteur',
                'prenom' => 'promoteur',
                'username' => $this->generateUniqueUsername('promoteur', $etablissements),
                'email' => 'promoteur@' . $etablissements->getSlug() . '.com',
                'roles' => ['ROLE_SUPERADMIN'],
                'password' => 'promoteur'
            ],
            [
                'nom' => 'directeur',
                'prenom' => 'directeur',
                'username' => $this->generateUniqueUsername('directeur', $etablissements),
                'email' => 'directeur@' . $etablissements->getSlug() . '.com',
                'roles' => ['ROLE_DIRECTEUR'],
                'password' => 'directeur'
            ]
        ];

        foreach ($usersToCreate as $userData) {
            $user = new Users();
            $user->setNom($userData['nom']);
            $user->setPrenom($userData['prenom']);
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $user->setEtablissement($etablissements);

            // Hachage du mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userData['password']
            );
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
        }
    }

    public function preUpdate(Etablissements $etablissements, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        if ($user === null) {
            $etablissements
                ->setUpdatedAt(new \DateTimeImmutable('now'))
                ->setSlug($this->getClassesSlug($etablissements));
        } else {
            $etablissements
                ->setUpdatedAt(new \DateTimeImmutable('now'))
                ->setUpdatedBy($user)
                ->setSlug($this->getClassesSlug($etablissements));
        }
    }

    private function generateUniqueUsername(string $base, Etablissements $etablissements): string
    {
        return $base . '-' . uniqid();
    }

    private function getClassesSlug(Etablissements $etablissements): string
    {
        $slug = mb_strtolower($etablissements->getDesignation() . '-' . $etablissements->getId() . '-' . time(), 'UTF-8');
        return $this->slugger->slug($slug);
    }

    private function createDefaultCyclesNiveauxClasses(Etablissements $etablissements): void
    {
        $cyclesConfig = [
            [
                'nom' => 'Pré Scolaire',
                'niveaux' => [
                    ['nom' => 'Petite Section', 'classes' => ['PS1-A', 'PS2-A'], 'scolarites1' => [], 'scolarites2' => []],
                    ['nom' => 'Moyenne Section', 'classes' => ['MS1-A', 'MS2-A'], 'scolarites1' => [], 'scolarites2' => []],
                    ['nom' => 'Grande Section', 'classes' => ['GS1-A', 'GS2-A'], 'scolarites1' => [], 'scolarites2' => []],
                ]
            ],
            [
                'nom' => '1er Cycle',
                'niveaux' => [
                    ['nom' => '1ère Année', 'classes' => ['1ère A', '1ère B', '1ère C'], 'scolarites1' => [1, 2, 3], 'scolarites2' => [0]],
                    ['nom' => '2ème Année', 'classes' => ['2ème A', '2ème B', '2ème C'], 'scolarites1' => [2, 3, 4, 5], 'scolarites2' => [0]],
                    ['nom' => '3ème Année', 'classes' => ['3ème A', '3ème B', '3ème C'], 'scolarites1' => [3, 4, 5, 6], 'scolarites2' => [0]],
                    ['nom' => '4ème Année', 'classes' => ['4ème A', '4ème B', '4ème C'], 'scolarites1' => [4, 5, 6, 7], 'scolarites2' => [0]],
                    ['nom' => '5ème Année', 'classes' => ['5ème A', '5ème B', '5ème C'], 'scolarites1' => [5, 6, 7, 8], 'scolarites2' => [0]],
                    ['nom' => '6ème Année', 'classes' => ['6ème A', '6ème B', '6ème C'], 'scolarites1' => [6, 7, 8, 9], 'scolarites2' => [0]],
                ]
            ],
            [
                'nom' => '2nd Cycle',
                'niveaux' => [
                    ['nom' => '7ème Année', 'classes' => ['7ème A', '7ème B', '7ème C'], 'scolarites1' => [6, 7, 8], 'scolarites2' => [1, 2, 3]],
                    ['nom' => '8ème Année', 'classes' => ['8ème A', '8ème B', '8ème C'], 'scolarites1' => [6, 7, 8], 'scolarites2' => [2, 3, 4, 5]],
                    ['nom' => '9ème Année', 'classes' => ['9ème A', '9ème B', '9ème C'], 'scolarites1' => [6, 7, 8], 'scolarites2' => [3, 4, 5, 6]],
                ]
            ]
        ];
    
        $statuts = $this->initializeStatuts();
    
        foreach ($cyclesConfig as $cycleData) {
            $cycle = new Cycles();
            $cycle->setDesignation($cycleData['nom'])
                ->setEtablissement($etablissements);
    
            $this->entityManager->persist($cycle);
    
            foreach ($cycleData['niveaux'] as $niveauData) {
                $niveau = new Niveaux();
                $niveau->setDesignation($niveauData['nom'])
                    ->setCycle($cycle);
    
                $this->entityManager->persist($niveau);
    
                // Créer et associer Scolarites1
                foreach ($niveauData['scolarites1'] as $scolarite1Value) {
                    $scolarites1 = new Scolarites1();
                    $scolarites1->setScolarite((string) $scolarite1Value)
                        ->setNiveau($niveau);
                    $this->entityManager->persist($scolarites1);
    
                    // Créer et associer Scolarites2
                    foreach ($niveauData['scolarites2'] as $scolarite2Value) {
                        $scolarites2 = new Scolarites2();
                        $scolarites2->setScolarite((string) $scolarite2Value)
                            ->setScolarite1($scolarites1)
                            ->setNiveau($niveau);
                        $this->entityManager->persist($scolarites2);
                    }
                }
    
                $this->attachStatutsToNiveau($niveau, $niveauData['nom'], $statuts);
    
                foreach ($niveauData['classes'] as $classeNom) {
                    $classe = new Classes();
                    $classe->setDesignation($classeNom)
                        ->setNiveau($niveau)
                        ->setCapacite(45)
                        ->setEffectif(0);
    
                    $this->entityManager->persist($classe);
                }
            }
        }
    }

    private function initializeStatuts(): array
    {
        $statutDefinitions = [
            '1ère inscription' => ['niveaux_speciaux' => true],
            'transfert arrivés' => ['niveaux_generaux' => true],
            'transfert départ' => ['niveaux_generaux' => true],
            'passant' => ['niveaux_generaux' => true],
            'redoublant' => ['niveaux_generaux' => true],
            'sans dossier' => ['niveaux_generaux' => true],
            'passe au D.E.F' => ['niveau_specifique' => '9ème Année'],
            'passe au C.E.P' => ['niveau_specifique' => '6ème Année'],
            'abandon' => ['niveaux_generaux' => true],
            'exclus' => ['niveaux_generaux' => true],
            'candidat Libre' => ['niveaux_specifiques' => ['6ème Année', '9ème Année']]
        ];

        $statuts = [];
        foreach ($statutDefinitions as $designation => $config) {
            $statut = $this->entityManager->getRepository(Statuts::class)->findOneBy(['designation' => $designation]);
            if (!$statut) {
                $statut = new Statuts();
                $statut->setDesignation($designation);
                $this->entityManager->persist($statut);
            }
            $statuts[$designation] = $statut;
        }

        return $statuts;
    }

    private function attachStatutsToNiveau(Niveaux $niveau, string $niveauDesignation, array $statuts): void
    {
        $specialNiveaux = ['Petite Section', 'Moyenne Section', 'Grande Section', '1ère Année'];

        // Statuts pour les niveaux spéciaux
        $specialStatuts = [
            '1ère inscription',
            'transfert départ',
            'passant',
            'redoublant',
            'sans dossier',
            'abandon'
        ];

        // Si le niveau est spécial, ajouter tous les statuts spéciaux
        if (in_array($niveauDesignation, $specialNiveaux)) {
            foreach ($specialStatuts as $statutName) {
                if (isset($statuts[$statutName])) {
                    $niveau->addStatut($statuts[$statutName]);
                } else {
                    throw new \Exception("Statut '$statutName' non trouvé.");
                }
            }
            return; // On arrête ici pour les niveaux spéciaux
        }

        // Statuts généraux pour les autres niveaux
        $generalStatuts = [
            'transfert arrivés',
            'transfert départ',
            'passant',
            'redoublant',
            'sans dossier',
            'abandon',
            'exclus'
        ];

        foreach ($generalStatuts as $statutName) {
            if (isset($statuts[$statutName])) {
                $niveau->addStatut($statuts[$statutName]);
            } else {
                throw new \Exception("Statut '$statutName' non trouvé.");
            }
        }

        // Statuts spéciaux pour certains niveaux
        switch ($niveauDesignation) {
            case '6ème Année':
                $niveau->addStatut($statuts['passe au C.E.P']);
                $niveau->addStatut($statuts['candidat Libre']);
                break;

            case '9ème Année':
                $niveau->addStatut($statuts['passe au D.E.F']);
                $niveau->addStatut($statuts['candidat Libre']);
                break;
        }
    }
}
