<?php

namespace App\Repository;

use App\Entity\AnneeScolaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnneeScolaires>
 */
class AnneeScolairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnneeScolaires::class);
    }

    public function findLatest(): ?AnneeScolaires
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.anneeFin', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findCurrentYear(): ?AnneeScolaires
    {
        return $this->findOneBy(['isCurrent' => true], ['anneeFin' => 'DESC']);
    }

    public function clearCurrentYearStatus(): void
    {
        $this->createQueryBuilder('a')
            ->update()
            ->set('a.isCurrent', ':false')
            ->setParameter('false', false)
            ->getQuery()
            ->execute();
    }
    //    /**
    //     * @return AnneeScolaires[] Returns an array of AnneeScolaires objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AnneeScolaires
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
