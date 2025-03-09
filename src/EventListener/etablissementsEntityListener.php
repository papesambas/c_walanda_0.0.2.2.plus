<?php

namespace App\EventListener;

use App\Entity\Etablissements;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

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
            $user->setEtablissements($etablissements);

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
        }else{
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
}
