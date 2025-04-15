<?php

namespace App\EventListener;

use App\Entity\Users;
use App\Entity\Eleves;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class elevesEntityListener
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

    public function prePersist(Eleves $eleves, LifecycleEventArgs $arg): void
    {
        $this->generateMatricule($eleves);
        $this->setCreatedFields($eleves);
        $this->createDefaultUsers($eleves);
    }

    public function preUpdate(Eleves $eleves, LifecycleEventArgs $arg): void
    {
        $this->generateMatricule($eleves);
        $this->setUpdatedFields($eleves);
    }

    private function generateMatricule(Eleves $eleves): void
    {
        if (null !== $eleves->getMatricule()) {
            return;
        }
    
        // Éléments fixes du matricule
        $recrutem = $eleves->getDateRecrutement()->format('Y'); // 4 caractères (année)
        $dateNaissJour = $eleves->getDateNaissance()->format('d'); // 2 caractères (jour)
        $dateNaissMois = $eleves->getDateNaissance()->format('m'); // 2 caractères (mois)
        $nom = substr($eleves->getNom(), 0, 2); // 2 caractères (nom)
        $prenom = substr($eleves->getPrenom(), 0, 2); // 2 caractères (prénom)
    
        // Longueur des éléments fixes
        $longueurElementsFixes = strlen($recrutem) + strlen($dateNaissJour) + strlen($dateNaissMois) + strlen($nom) + strlen($prenom) + 2; // +2 pour les séparateurs "-"
    
        // Longueur de la partie aléatoire nécessaire pour atteindre 20 caractères
        $longueurPartieAleatoire = 25 - $longueurElementsFixes;
    
        // Caractères autorisés pour la partie aléatoire
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $partieAleatoire = '';
        $isUnique = false;
    
        while (!$isUnique) {
            // Générer la partie aléatoire
            $partieAleatoire = '';
            for ($i = 0; $i < $longueurPartieAleatoire; $i++) {
                $partieAleatoire .= $caracteres[rand(0, strlen($caracteres) - 1)];
            }
    
            // Construire le matricule complet
            $matricule = $recrutem . $nom . $dateNaissJour . $dateNaissMois . $prenom . '-' . $partieAleatoire;
    
            // Vérifier l'unicité du matricule
            $existingEleve = $this->entityManager->getRepository(Eleves::class)->findOneBy(['matricule' => $matricule]);
            if ($existingEleve === null) {
                $isUnique = true;
            }
        }
    
        // Assigner le matricule à l'élève
        $eleves->setMatricule($matricule);
    }
    private function setCreatedFields(Eleves $eleves): void
    {
        $currentTime = new \DateTimeImmutable('now');
        $eleves->setCreatedAt($currentTime)
            ->setFullname($this->getFullName($eleves))
            ->setSlug($this->getClassesSlug($eleves));

        $user = $this->security->getUser();
        if ($user) {
            $eleves->setCreatedBy($user);
        }
    }

    private function setUpdatedFields(Eleves $eleves): void
    {
        $currentTime = new \DateTimeImmutable('now');
        $eleves->setUpdatedAt($currentTime)
            ->setFullname($this->getFullName($eleves))
            ->setSlug($this->getClassesSlug($eleves));

        $user = $this->security->getUser();
        if ($user) {
            $eleves->setUpdatedBy($user);
        }
    }

    private function getClassesSlug(Eleves $eleves): string
    {
        $slug = mb_strtolower($eleves->getNom() . '-' . $eleves->getPrenom() . '-' . time(), 'UTF-8');
        return $this->slugger->slug($slug);
    }

    private function getFullName(Eleves $eleves): string
    {
        $prenom = ucfirst(mb_strtolower($eleves->getPrenom(), 'UTF-8'));
        $nom = mb_strtoupper($eleves->getNom(), 'UTF-8');
        return $prenom . ' ' . $nom;
    }

    private function createDefaultUsers(Eleves $eleves): void
    {
        if (null !== $eleves->getUsers()) {
            return;
        }

        $username = $this->generateUniqueUsername();
        $nom = $eleves->getNom();
        $prenom = $eleves->getPrenom();
        $email = 'inscription@' . $eleves->getSlug() . '.com';
        $role = ['ROLE_ELEVES'];
        $password = "eleve";

        $user = new Users();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($role);
        $user->setEleve($eleves);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        
    }

    private function generateUniqueUsername(): string
    {
        $longueurUsername = 10;
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $username = '';
        $isUnique = false;

        while (!$isUnique) {
            $username = '';
            for ($i = 0; $i < $longueurUsername; $i++) {
                $username .= $caracteres[rand(0, strlen($caracteres) - 1)];
            }

            $username .= '-' . rand(10000, 99999) . '-' . substr(time(), -4);

            $existingUser = $this->entityManager->getRepository(Users::class)->findOneBy(['username' => $username]);
            if ($existingUser === null) {
                $isUnique = true;
            }
        }

        return $username;
    }
}