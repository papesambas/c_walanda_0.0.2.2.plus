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

    public function findByRedoublement2AndScolarites1AndScolarites2(?Redoublements2 $redoublements2, ?Scolarites1 $scolarites1, ?Scolarites2 $scolarites2): array
    {
        if ($redoublements2 === null || $scolarites1 === null || $scolarites2 === null) {
            return [];
        }
    
        // Création du QueryBuilder
        return $this->createQueryBuilder('r')
            ->leftJoin('r.scolarites1', 's1') // Jointure gauche avec Scolarites1
            ->leftJoin('r.scolarites2', 's2') // Jointure gauche avec Scolarites2
            ->andWhere('s1 = :scolarite1')    
            ->andWhere('s2 = :scolarite2')    
            ->andWhere('r.redoublements2 = :redoublement2') // Correction du paramètre
            ->setParameter('scolarite1', $scolarites1)
            ->setParameter('scolarite2', $scolarites2)
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
