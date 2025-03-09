<?php

namespace App\EventListener;

use App\Entity\Cycles;
use LogicException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class cyclesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Cycles $cycles, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $cycles
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($cycles));
        }else{
            $cycles
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($cycles));
        }
    }

    public function preUpdate(Cycles $cycles, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $cycles
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($cycles));
        }else{
            $cycles
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($cycles));
        }
    }


    private function getClassesSlug(Cycles $cycles): string
    {
        $slug = mb_strtolower($cycles->getDesignation() . '-' . $cycles->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
