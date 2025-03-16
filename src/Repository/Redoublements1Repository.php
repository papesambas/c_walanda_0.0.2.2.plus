<?php

namespace App\Repository;

use App\Entity\Redoublements1;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Redoublements1>
 */
class Redoublements1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redoublements1::class);
    }

    /**
     * Undocumented function
     *
     * @param Scolarites1 $scolarites1
     * @param Scolarites2 $scolarites2
     * @return array
     */
    public function findByScolarites1AndScolarites2(?Scolarites1 $scolarites1, ?Scolarites2 $scolarites2): array
    {
        if ($scolarites1 === null || $scolarites2 === null) {
            return [];
        }

        return $this->createQueryBuilder('r')
            ->innerJoin('r.scolarites1', 's1') // Jointure avec Scolarites1
            ->innerJoin('r.scolarites2', 's2') // Jointure avec Scolarites2
            ->andWhere('s1 = :scolarite1')     // Filtre sur Scolarites1
            ->andWhere('s2 = :scolarite2')     // Filtre sur Scolarites2
            ->setParameter('scolarite1', $scolarites1)
            ->setParameter('scolarite2', $scolarites2)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    


    //    /**
    //     * @return Redoublements1[] Returns an array of Redoublements1 objects
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

    //    public function findOneBySomeField($value): ?Redoublements1
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
