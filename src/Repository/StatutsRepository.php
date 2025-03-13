<?php

namespace App\Repository;

use App\Entity\Niveaux;
use App\Entity\Statuts;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Statuts>
 */
class StatutsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statuts::class);
    }

    public function findStatutsForNlEnregistrement(?Niveaux $niveaux = null): array
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.designation = :inscription OR s.designation = :transfert')
            ->setParameter('inscription', '1ère Inscription')
            ->setParameter('transfert', 'Transfert Arrivé');
    
        if ($niveaux) {
            $qb->join('s.niveaux', 'n')
               ->andWhere('n.id = :niveauId')
               ->setParameter('niveauId', $niveaux->getId());
        }
    
        return $qb->getQuery()->getResult();
    }

    public function findByNiveau(int $niveauId): array
    {
        $query = $this->createQueryBuilder('s')
            ->join('s.niveaux', 'n')
            ->where('n.id = :niveauId')
            ->setParameter('niveauId', $niveauId)
            ->getQuery();
    
        return $query->getResult();
    }
    

//    /**
//     * @return Statuts[] Returns an array of Statuts objects
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

//    public function findOneBySomeField($value): ?Statuts
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
