<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Departements;
use App\Entity\Echeances;
use App\Entity\FraisScolaires;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class fraisScolairesEntityListener
{
    private $Security;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Security = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(FraisScolaires $fraisScolaires, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new LogicException('User cannot be null here ...');
        }*/


        $fraisScolaires
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($fraisScolaires));

    }

    public function preUpdate(FraisScolaires $fraisScolaires, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new LogicException('User cannot be null here ...');
        }*/

        $fraisScolaires
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($fraisScolaires));
    }




    private function getClassesSlug(FraisScolaires $fraisScolaires): string
    {
        $slug = mb_strtolower($fraisScolaires->getDesignation() . '-' . $fraisScolaires->getId() . '' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
