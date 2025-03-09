<?php

namespace App\EventListener;

use App\Entity\Caisses;
use App\Entity\Cercles;
use LogicException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class caissesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Caisses $caisses, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new LogicException('User cannot be null here ...');
        }*/


        $caisses
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setDateOp(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($caisses));
    }

    public function preUpdate(Caisses $caisses, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new LogicException('User cannot be null here ...');
        }*/

        $caisses
            ->setUpdatedAt(new \DateTimeImmutable('now'));
    }


    private function getClassesSlug(Caisses $caisses): string
    {
        $slug = mb_strtolower($caisses->getLibelle() . '-' . $caisses->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
