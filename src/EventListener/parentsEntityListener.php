<?php

namespace App\EventListener;

use App\Entity\Parents;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class parentsEntityListener
{
    private $Security;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Security = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Parents $parents, LifecycleEventArgs $arg): void
    {
        $user = $this->Security->getUser();
        $parents->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($parents, $arg));

        if ($user !== null) {
            $parents->setCreatedBy($user);
        }
    }

    public function preUpdate(Parents $parents, LifecycleEventArgs $arg): void
    {
        $user = $this->Security->getUser();
        $parents->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($parents, $arg));

        if ($user !== null) {
            $parents->setUpdatedBy($user);
        }
    }

    private function getClassesSlug(Parents $parents, LifecycleEventArgs $args): string
    {
        // Récupère le repository des Parents pour vérifier l'unicité
        $repository = $args->getObjectManager()->getRepository(Parents::class);

        // Base du slug sans ID (car l'ID n'est pas encore défini lors du prePersist)
        $baseSlug = mb_strtolower($parents->getPere() . '-' . $parents->getMere(), 'UTF-8');
        $slug = $this->Slugger->slug($baseSlug)->toString();

        // Vérifie si le slug existe déjà dans la base de données
        $counter = 1;
        $uniqueSlug = $slug;

        // Si le slug existe déjà, ajoute un suffixe incrémental
        while ($repository->findOneBy(['slug' => $uniqueSlug])) {
            $uniqueSlug = $slug . '-' . $counter;
            $counter++;
        }

        return $uniqueSlug;
    }


}
