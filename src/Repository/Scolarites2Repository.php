<?php

namespace App\Repository;

use App\Entity\Niveaux;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Scolarites2>
 */
class Scolarites2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scolarites2::class);
    }

    public function findByNiveauxAndScolarites1(Niveaux $niveaux, Scolarites1 $scolarites1): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.scolarite1 = :scolarite1')
            ->andWhere('s.niveau = :niveau')
            ->setParameter('val', $niveaux)
            ->setParameter('val', $scolarites1)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return Scolarites2[] Returns an array of Scolarites2 objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Scolarites2
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
