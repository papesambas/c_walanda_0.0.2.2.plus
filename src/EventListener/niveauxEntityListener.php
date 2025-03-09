<?php

namespace App\EventListener;

use App\Entity\Niveaux;
use LogicException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class niveauxEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Niveaux $niveaux, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $niveaux
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($niveaux));
        }else{
            $niveaux
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($niveaux));
        }
    }

    public function preUpdate(Niveaux $niveaux, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $niveaux
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($niveaux));
        }else{
            $niveaux
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($niveaux));
        }
    }


    private function getClassesSlug(Niveaux $niveaux): string
    {
        $slug = mb_strtolower($niveaux->getDesignation() . '-' . $niveaux->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
