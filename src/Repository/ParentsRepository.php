<?php

namespace App\Repository;

use App\Entity\Meres;
use App\Entity\Parents;
use App\Entity\Peres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parents>
 */
class ParentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parents::class);
    }

    /**
     * Summary of findByPereOrMere
     * @param array $peres
     * @param array $meres
     * @return array
     */
    public function findByPereOrMere(array $peres, array $meres): array
    {
        $queryBuilder = $this->createQueryBuilder('p');
    
        // Si aucun père ni mère n'est fourni, retourner un tableau vide
        if (empty($peres) && empty($meres)) {
            return [];
        }
    
        // Joindre les entités père et mère pour pouvoir trier par leurs propriétés
        $queryBuilder
            ->leftJoin('p.pere', 'pere') // Jointure avec l'entité père
            ->leftJoin('p.mere', 'mere'); // Jointure avec l'entité mère
    
        // Ajouter les conditions en fonction des pères et mères
        if (!empty($peres) && !empty($meres)) {
            // Cas où il y a à la fois des pères et des mères
            $queryBuilder
                ->andWhere('p.pere IN (:peres) AND p.mere IN (:meres)') // Utiliser OR au lieu de AND
                ->setParameter('peres', $peres)
                ->setParameter('meres', $meres)
                ->orderBy('pere.fullname', 'ASC')
                ->addOrderBy('pere.fullname', 'ASC');
        } elseif (!empty($peres)) {
            // Cas où il y a seulement des pères
            $queryBuilder
                ->andWhere('p.pere IN (:peres)')
                ->setParameter('peres', $peres)
                ->orderBy('pere.fullname', 'ASC'); // Trier par le nom du père
        } elseif (!empty($meres)) {
            // Cas où il y a seulement des mères
            $queryBuilder
                ->andWhere('p.mere IN (:meres)')
                ->setParameter('meres', $meres)
                ->orderBy('mere.fullname', 'ASC'); // Trier par le nom de la mère
        }
    
        // Retourner les résultats
        return $queryBuilder->getQuery()->getResult();
    }

    public function findOneByPereAndMere(array $peres, array $meres): ?Parents
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.pere = :pere')
            ->andWhere('p.mere = :mere')
            ->setParameter('pere', $peres)
            ->setParameter('mere', $meres)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    //    /**
    //     * @return Parents[] Returns an array of Parents objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Parents
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
