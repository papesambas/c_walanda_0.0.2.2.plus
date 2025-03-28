<?php

namespace App\Repository;

use App\Entity\Eleves;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Eleves>
 */
class ElevesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eleves::class);
    }

    public function findByCommune($commune): array
    {
        return $this->createQueryBuilder('e')
            ->leftjoin('e.lieuNaissance', 'ln')  // Jointure avec LieuNaissance
            ->andWhere('ln.commune = :commune')   // Filtrer sur le nom de la commune
            ->setParameter('commune', $commune)
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByCercle($cercle): array
    {
        return $this->createQueryBuilder('e')
            ->leftjoin('e.lieuNaissance', 'ln')  // Jointure avec LieuNaissance
            ->leftjoin('ln.commune', 'co')        // Jointure avec Commune
            ->andWhere('co.cercle = :cercle')   // Filtrer sur le nom de la commune
            ->setParameter('cercle', $cercle)
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByRegion($region): array
    {
        return $this->createQueryBuilder('e')
            ->leftjoin('e.lieuNaissance', 'ln')  // Jointure avec LieuNaissance
            ->leftjoin('ln.commune', 'co')        // Jointure avec Commune
            ->leftjoin('co.cercle', 'c')        // Jointure avec Commune
            ->andWhere('c.region = :region')   // Filtrer sur le nom de la commune
            ->setParameter('region', $region)
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Eleves[] Returns an array of Eleves objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Eleves
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
