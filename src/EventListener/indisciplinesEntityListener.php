<?php

namespace App\EventListener;

use App\Entity\Absences;
use App\Entity\Indiscipline;
use LogicException;
use App\Entity\Retards;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class indisciplinesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Indiscipline $indiscipline, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $indiscipline
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($indiscipline));
        }else{
            $indiscipline
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($indiscipline));
        }
    }

    public function preUpdate(Indiscipline $indiscipline, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $indiscipline
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($indiscipline));
        }else{
            $indiscipline
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($indiscipline));
        }
    }


    private function getClassesSlug(Indiscipline $indiscipline): string
    {
        $slug = mb_strtolower($indiscipline->getEleve() . '-' . $indiscipline->getId() . '' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
