<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreFlushEventArgs;

class DisableForeignKeyConstraintsListener
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function preFlush(PreFlushEventArgs $args): void
    {
        // Désactiver les clés étrangères
        $connection = $this->entityManager->getConnection();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=0');
    }

    public function postFlush(): void
    {
        // Réactiver les clés étrangères
        $connection = $this->entityManager->getConnection();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=1');
    }
}
