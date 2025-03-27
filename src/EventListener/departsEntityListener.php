<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Departs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class departsEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Departs $departs, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $departs
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($departs));
        }else{
            $departs
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setDateDepart(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($departs));
        }
    }

    public function preUpdate(Departs $departs, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $departs
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($departs));
        }else{
            $departs
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($departs));
        }
    }


    private function getClassesSlug(Departs $departs): string
    {
        $slug = mb_strtolower($departs->getMotif() . '-' . $departs->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
