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
     * Summary of findByScolarites1AndScolarites2
     * @param mixed $scolarites1
     * @param mixed $scolarites2
     * @return array
     */
    public function findByScolarites1AndScolarites2(?Scolarites1 $scolarites1, ?Scolarites2 $scolarites2): array
    {
        $qb = $this->createQueryBuilder('r')
            ->leftJoin('r.scolarite1', 's1') // Jointure facultative avec Scolarites1
            ->leftJoin('r.scolarite2', 's2') // Jointure facultative avec Scolarites2
            ->orderBy('r.id', 'ASC');
    
        if ($scolarites1) {
            $qb->andWhere('s1 = :scolarite1')
               ->setParameter('scolarite1', $scolarites1);
        }
    
        if ($scolarites2) {
            $qb->andWhere('s2 = :scolarite2')
               ->setParameter('scolarite2', $scolarites2);
        }
    
        return $qb->getQuery()->getResult();
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
