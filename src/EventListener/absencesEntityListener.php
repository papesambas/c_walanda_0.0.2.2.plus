<?php

namespace App\EventListener;

use App\Entity\Absences;
use LogicException;
use App\Entity\Retards;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class absencesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Absences $absences, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $absences
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($absences));
        }else{
            $absences
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($absences));
        }
    }

    public function preUpdate(Absences $absences, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $absences
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($absences));
        }else{
            $absences
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($absences));
        }
    }


    private function getClassesSlug(Absences $absences): string
    {
        $slug = mb_strtolower($absences->getEleve() . '-' . $absences->getId() . '' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
