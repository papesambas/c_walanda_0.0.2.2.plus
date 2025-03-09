<?php

namespace App\EventListener;

use App\Entity\Enseignements;
use LogicException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class enseignementsEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Enseignements $enseignements, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $enseignements
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($enseignements));
        }else{
            $enseignements
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($enseignements));
        }
    }

    public function preUpdate(Enseignements $enseignements, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $enseignements
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($enseignements));
        }else{
            $enseignements
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($enseignements));
        }
    }


    private function getClassesSlug(Enseignements $enseignements): string
    {
        $slug = mb_strtolower($enseignements->getDesignation() . '-' . $enseignements->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
