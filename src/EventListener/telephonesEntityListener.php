<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Telephones1;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class telephonesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Telephones1 $telephone, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $telephone
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($telephone));
        }else{
            $telephone
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($telephone));
        }
    }

    public function preUpdate(Telephones1 $telephone, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $telephone
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($telephone));
        }else{
            $telephone
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($telephone));
        }
    }


    private function getClassesSlug(Telephones1 $telephone): string
    {
        $slug = mb_strtolower($telephone->getNumero() . '-' . $telephone->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}
