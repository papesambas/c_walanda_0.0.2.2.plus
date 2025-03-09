<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Departements;
use App\Entity\Echeances;
use App\Entity\FraisTypes;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class fraisTypeEntityListener
{
    private $Security;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Security = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(FraisTypes $fraisType, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new LogicException('User cannot be null here ...');
        }*/


        $fraisType
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($fraisType));
    }

    public function preUpdate(FraisTypes $fraisType, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new LogicException('User cannot be null here ...');
        }*/

        $fraisType
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($fraisType));
    }




    private function getClassesSlug(FraisTypes $fraisType): string
    {
        $slug = mb_strtolower($fraisType->getPeriode() . '-' . $fraisType->getStatut() . '' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
