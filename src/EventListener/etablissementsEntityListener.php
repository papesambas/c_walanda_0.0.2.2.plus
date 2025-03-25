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
use App\Entity\Redoublements1;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
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
        $etablissements = $arg->getObject();

        if (!$etablissements instanceof Etablissements) {
            return;
        }

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
        $etablissements = $arg->getObject();

        if (!$etablissements instanceof Etablissements) {
            return;
        }

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
        $slug = mb_strtolower($etablissements->getDesignation() . '-' . time(), 'UTF-8');
        return $this->slugger->slug($slug);
    }

    private function createDefaultCyclesNiveauxClasses(Etablissements $etablissements): void
    {
        $cyclesConfig = [
            [
                'nom' => 'Pré Scolaire',
                'niveaux' => [
                    ['nom' => 'Petite Section', 'minAge' => 4, 'maxAge' => 3, 'minDate' => 1, 'maxDate' => 0, 'classes' => ['PS1-A', 'PS2-A'], 'scolarites1' => [], 'scolarites2' => []],
                    ['nom' => 'Moyenne Section', 'minAge' => 5, 'maxAge' => 4, 'minDate' => 2, 'maxDate' => 0, 'classes' => ['MS1-A', 'MS2-A'], 'scolarites1' => [], 'scolarites2' => []],
                    ['nom' => 'Grande Section', 'minAge' => 6, 'maxAge' => 5, 'minDate' => 3, 'maxDate' => 0, 'classes' => ['GS1-A', 'GS2-A'], 'scolarites1' => [], 'scolarites2' => []],
                ]
            ],
            [
                'nom' => '1er Cycle',
                'niveaux' => [
                    ['nom' => '1ère Année', 'minAge' => 9, 'maxAge' => 5, 'minDate' => 4, 'maxDate' => 0, 'classes' => ['1ère A', '1ère B', '1ère C'], 'scolarites1' => [1, 2, 3], 'scolarites2' => [0]],
                    ['nom' => '2ème Année', 'minAge' => 10, 'maxAge' => 6, 'minDate' => 5, 'maxDate' => 1, 'classes' => ['2ème A', '2ème B', '2ème C'], 'scolarites1' => [2, 3, 4, 5], 'scolarites2' => [0]],
                    ['nom' => '3ème Année', 'minAge' => 11, 'maxAge' => 7, 'minDate' => 6, 'maxDate' => 2, 'classes' => ['3ème A', '3ème B', '3ème C'], 'scolarites1' => [3, 4, 5, 6], 'scolarites2' => [0]],
                    ['nom' => '4ème Année', 'minAge' => 12, 'maxAge' => 8, 'minDate' => 7, 'maxDate' => 3, 'classes' => ['4ème A', '4ème B', '4ème C'], 'scolarites1' => [4, 5, 6, 7], 'scolarites2' => [0]],
                    ['nom' => '5ème Année', 'minAge' => 13, 'maxAge' => 9, 'minDate' => 8, 'maxDate' => 4, 'classes' => ['5ème A', '5ème B', '5ème C'], 'scolarites1' => [5, 6, 7, 8], 'scolarites2' => [0]],
                    ['nom' => '6ème Année', 'minAge' => 14, 'maxAge' => 10, 'minDate' => 9, 'maxDate' => 5, 'classes' => ['6ème A', '6ème B', '6ème C'], 'scolarites1' => [6, 7, 8, 9], 'scolarites2' => [0]],
                ]
            ],
            [
                'nom' => '2nd Cycle',
                'niveaux' => [
                    ['nom' => '7ème Année', 'minAge' => 15, 'maxAge' => 11, 'minDate' => 10, 'maxDate' => 6, 'classes' => ['7ème A', '7ème B', '7ème C'], 'scolarites1' => [6, 7, 8], 'scolarites2' => [1, 2, 3]],
                    ['nom' => '8ème Année', 'minAge' => 16, 'maxAge' => 12, 'minDate' => 11, 'maxDate' => 7, 'classes' => ['8ème A', '8ème B', '8ème C'], 'scolarites1' => [6, 7, 8], 'scolarites2' => [2, 3, 4, 5]],
                    ['nom' => '9ème Année', 'minAge' => 17, 'maxAge' => 13, 'minDate' => 12, 'maxDate' => 8, 'classes' => ['9ème A', '9ème B', '9ème C'], 'scolarites1' => [6, 7, 8], 'scolarites2' => [3, 4, 5, 6]],
                ]
            ]
        ];

        // **Définition des statuts spécifiques par niveau**
        $statutsParNiveau = [
            'Petite Section' => ['1ère Inscription', 'Passant', 'Sans Dossier', 'Abandon'],
            'Moyenne Section' => ['1ère Inscription', 'Passant', 'Sans Dossier', 'Abandon'],
            'Grande Section' => ['1ère Inscription', 'Passant', 'Sans Dossier', 'Abandon'],
            '1ère Année' => ['1ère Inscription', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Exclus', 'Abandon'],
            '2ème Année' => ['Transfert Arrivé', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Exclus', 'Abandon'],
            '3ème Année' => ['Transfert Arrivé', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Exclus', 'Abandon'],
            '4ème Année' => ['Transfert Arrivé', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Exclus', 'Abandon'],
            '5ème Année' => ['Transfert Arrivé', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Exclus', 'Abandon'],
            '6ème Année' => ['Transfert Arrivé', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Candidat Libre', 'Passe au C.E.P.', 'Exclus', 'Abandon'],
            '7ème Année' => ['Transfert Arrivé', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Exclus', 'Abandon'],
            '8ème Année' => ['Transfert Arrivé', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Exclus', 'Abandon'],
            '9ème Année' => ['Transfert Arrivé', 'Passant', 'Redoublant', 'Sans Dossier', 'Transfert Départ', 'Candidat Libre', 'Passe au D.E.F.', 'Exclus', 'Abandon'],
        ];

        foreach ($cyclesConfig as $cycleData) {
            $cycle = new Cycles();
            $cycle->setDesignation($cycleData['nom'])
                ->setEtablissement($etablissements);

            $this->entityManager->persist($cycle);

            foreach ($cycleData['niveaux'] as $niveauData) {
                $niveau = new Niveaux();
                $niveau->setDesignation($niveauData['nom'])
                    ->setMaxAge($niveauData['maxAge'])
                    ->setMinAge($niveauData['minAge'])
                    ->setMaxDate($niveauData['maxDate'])
                    ->setMinDate($niveauData['minDate'])
                    ->setCycle($cycle);
                $this->entityManager->persist($niveau);

                // **Ajout des statuts spécifiques à ce niveau**
                if (isset($statutsParNiveau[$niveauData['nom']])) {
                    foreach ($statutsParNiveau[$niveauData['nom']] as $nomStatut) {
                        $statut = new Statuts();
                        $statut->setDesignation($nomStatut);
                        $statut->setNiveau($niveau);
                        $this->entityManager->persist($statut);
                    }
                }


                // Créer et associer Scolarites1
                foreach ($niveauData['scolarites1'] as $scolarite1Value) {
                    $scolarites1 = new Scolarites1();
                    $scolarites1->setScolarite((string) $scolarite1Value)
                        ->setNiveau($niveau);
                    $this->entityManager->persist($scolarites1);

                    // Déterminer les Scolarites2 en fonction de Scolarites1 et du niveau
                    $scolarites2Values = [];
                    if ($cycleData['nom'] === '2nd Cycle') {
                        $scolarites2Values = $this->getScolarites2ForSecondCycle($scolarite1Value, $niveauData['nom']);
                    } else {
                        $scolarites2Values = $niveauData['scolarites2']; // Utiliser les valeurs par défaut pour les autres cycles
                    }

                    // Créer et associer Scolarites2
                    foreach ($scolarites2Values as $scolarite2Value) {
                        $scolarites2 = new Scolarites2();
                        $scolarites2->setScolarite((string) $scolarite2Value)
                            ->setScolarite1($scolarites1)
                            ->setNiveau($niveau);
                        $this->entityManager->persist($scolarites2);
                    }
                }

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

    private function getScolarites2ForSecondCycle(int $scolarite1, string $niveauDesignation): array
    {
        switch ($niveauDesignation) {
            case '7ème Année':
                switch ($scolarite1) {
                    case 6:
                        return [1, 2, 3];
                    case 7:
                        return [1, 2, 3];
                    case 8:
                        return [1, 2];
                    default:
                        return [];
                }
            case '8ème Année':
                switch ($scolarite1) {
                    case 6:
                        return [2, 3, 4, 5];
                    case 7:
                        return [2, 3, 4];
                    case 8:
                        return [2, 3];
                    default:
                        return [];
                }
            case '9ème Année':
                switch ($scolarite1) {
                    case 6:
                        return [3, 4, 5, 6];
                    case 7:
                        return [3, 4, 5];
                    case 8:
                        return [3, 4];
                    default:
                        return [];
                }
            default:
                return []; // Par défaut, retourne un tableau vide
        }
    }

    private function initializeStatuts(): array
    {
        $statutDefinitions = [
            '1ère Inscription' => ['niveaux_speciaux' => true],
            'Transfert Arrivé' => ['niveaux_generaux' => true],
            'Transfert Départ' => ['niveaux_generaux' => true],
            'Passant' => ['niveaux_generaux' => true],
            'Redoublant' => ['niveaux_generaux' => true],
            'Sans Dossier' => ['niveaux_generaux' => true],
            'Passe au D.E.F' => ['niveau_specifique' => '9ème Année'],
            'Passe au C.E.P' => ['niveau_specifique' => '6ème Année'],
            'Abandon' => ['niveaux_generaux' => true],
            'Exclus' => ['niveaux_generaux' => true],
            'Candidat Libre' => ['niveaux_specifiques' => ['6ème Année', '9ème Année']]
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
            '1ère Inscription',
            'Transfert Départ',
            'Passant',
            'Redoublant',
            'Sans Dossier',
            'Abandon'
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
            'Transfert Arrivé',
            'Transfert Départ',
            'Passant',
            'Redoublant',
            'Sans Dossier',
            'Abandon',
            'Exclus'
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
                $niveau->addStatut($statuts['Passe au C.E.P']);
                $niveau->addStatut($statuts['Candidat Libre']);
                break;

            case '9ème Année':
                $niveau->addStatut($statuts['Passe au D.E.F']);
                $niveau->addStatut($statuts['Candidat Libre']);
                break;
        }
    }
}
