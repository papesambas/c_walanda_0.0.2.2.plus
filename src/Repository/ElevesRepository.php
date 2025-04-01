<?php

namespace App\Repository;

use App\Entity\Eleves;
use App\Entity\Statuts;
use App\Data\SearchElevesData;
use App\Entity\EcoleProvenances;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Eleves>
 */
class ElevesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eleves::class);
    }

    public function findByParent($parent): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.parent = :parent')
            ->setParameter('parent', $parent)
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByPere($pere): array
    {
        return $this->createQueryBuilder('e')
            ->leftjoin('e.parent', 'pa')  // Jointure avec LieuNaissance
            ->andWhere('pa.pere = :pere')   // Filtrer sur le nom de la commune
            ->setParameter('pere', $pere)
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByMere($mere): array
    {
        return $this->createQueryBuilder('e')
            ->leftjoin('e.parent', 'pa')  // Jointure avec LieuNaissance
            ->andWhere('pa.mere = :mere')   // Filtrer sur le nom de la commune
            ->setParameter('mere', $mere)
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
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

    public function findByStatut(string $statutDesignation): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.statut', 's')
            ->andWhere('s.designation = :statut')
            ->setParameter('statut', $statutDesignation)
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByEcoleAnDernier(EcoleProvenances $ecole): array
    {
        return $this->createQueryBuilder('e')
        ->innerJoin('e.ecoleAnDernier', 'ea')
        ->andWhere('ea = :ecole')
        ->setParameter('ecole', $ecole)
        ->orderBy('e.fullname', 'ASC')
        ->getQuery()
        ->getResult();
    }


    public function findByEcoleRecrutement(EcoleProvenances $ecole): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.ecoleRecrutement = :ecole')   // Filtrer sur le nom de la commune
            ->setParameter('ecole', $ecole)
            ->orderBy('e.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findBySearchCriteria(SearchElevesData $data): array
    {
        $query = $this->createQueryBuilder('e');

        if (!empty($data->q)) {
            $query->andWhere('e.fullname LIKE :q')
                ->setParameter('q', '%' . $data->q . '%');
        }

        if ($data->age1 !== null) {
            $query->andWhere('e.age >= :age1')
                ->setParameter('age1', $data->age1);
        }

        if ($data->age2 !== null) {
            $query->andWhere('e.age <= :age2')
                ->setParameter('age2', $data->age2);
        }

        if (!$data->statut->isEmpty()) {
            $designations = $data->statut->map(function ($statut) {
                return $statut->getDesignation();
            })->toArray();

            $query
                ->leftJoin('e.statut', 's')
                ->andWhere('s.designation IN (:statuts)')
                ->setParameter('statuts', $designations);
        }

        if (!$data->classe->isEmpty()) {
            $query->andWhere('e.classe IN (:classes)')
                ->setParameter('classes', $data->classe);
        }

        return $query->orderBy('e.fullname', 'ASC')
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
