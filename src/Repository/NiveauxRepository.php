<?php

namespace App\Repository;

use App\Entity\Etablissements;
use App\Entity\Niveaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Niveaux>
 */
class NiveauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Niveaux::class);
    }

    public function findByEtablissement(Etablissements $etablissements): array
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.cycle', 'c') // Utilisez INNER JOIN si vous êtes sûr que chaque niveau a un cycle
            ->addSelect('c')
            ->andWhere('c.etablissement = :val')
            ->setParameter('val', $etablissements)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    //    /**
    //     * @return Niveaux[] Returns an array of Niveaux objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Niveaux
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
