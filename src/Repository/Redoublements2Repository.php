<?php

namespace App\Repository;

use App\Entity\Redoublements1;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use App\Entity\Redoublements2;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Redoublements2>
 */
class Redoublements2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redoublements2::class);
    }


    public function findByRedoublement1(?Redoublements1 $redoublements1): array
    {
        if ($redoublements1 === null) {
            return [];
        }
    
        // Création du QueryBuilder
        return $this->createQueryBuilder('r')
            ->andWhere('r.redoublement1 = :redoublement1') // Correction du paramètre
            ->setParameter('redoublement1', $redoublements1)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Redoublements2[] Returns an array of Redoublements2 objects
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

    //    public function findOneBySomeField($value): ?Redoublements2
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
