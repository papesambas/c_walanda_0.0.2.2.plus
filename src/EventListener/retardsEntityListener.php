<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Retards;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class retardsEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Retards $retards, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $retards
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($retards));
        }else{
            $retards
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($retards));
        }
    }

    public function preUpdate(Retards $retards, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $retards
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($retards));
        }else{
            $retards
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($retards));
        }
    }


    private function getClassesSlug(Retards $retards): string
    {
        $slug = mb_strtolower($retards->getEleves() . '-' . $retards->getId() . '' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
