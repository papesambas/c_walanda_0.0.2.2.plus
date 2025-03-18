<?php

namespace App\Repository;

use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Redoublements3>
 */
class Redoublements3Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redoublements3::class);
    }

    public function findByRedoublement2(?Redoublements2 $redoublements2): array
    {
        if ($redoublements2 === null) {
            return [];
        }
    
        // Création du QueryBuilder
        return $this->createQueryBuilder('r')
            ->andWhere('r.redoublement2 = :redoublement2') // Correction du paramètre
            ->setParameter('redoublement2', $redoublements2)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Redoublements3[] Returns an array of Redoublements3 objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Redoublements3
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
