<?php

namespace App\EventListener;

use App\Entity\AnneeScolaires;
use LogicException;
use App\Entity\Classes;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class anneeScolairesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(AnneeScolaires $annee, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $annee
            ->setCreatedAt(new \DateTimeImmutable('now'));
        }else{
            $annee
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user);
        }
    }

    public function preUpdate(AnneeScolaires $annee, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $annee
            ->setUpdatedAt(new \DateTimeImmutable('now'));
        }else{
            $annee
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user);
        }
    }
}
