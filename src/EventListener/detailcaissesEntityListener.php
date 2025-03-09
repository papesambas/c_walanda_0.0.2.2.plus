<?php

namespace App\EventListener;

use App\Entity\Caisses;
use App\Entity\Cercles;
use App\Entity\DetailsCaisses;
use LogicException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class detailcaissesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(DetailsCaisses $detail, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new LogicException('User cannot be null here ...');
        }*/


        $detail
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setDateOp(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($detail));
    }

    public function preUpdate(DetailsCaisses $detail, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new LogicException('User cannot be null here ...');
        }*/

        $detail
            ->setUpdatedAt(new \DateTimeImmutable('now'));
    }


    private function getClassesSlug(DetailsCaisses $detail): string
    {
        $slug = mb_strtolower($detail->getDesignation() . '-' . $detail->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}