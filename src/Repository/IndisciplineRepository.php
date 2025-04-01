<?php

namespace App\Repository;

use App\Entity\Eleves;
use App\Entity\Indiscipline;
use App\Entity\AnneeScolaires;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Indiscipline>
 */
class IndisciplineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Indiscipline::class);
    }

    public function findExistingIndiscipline(
        Eleves $eleve,
        \DateTimeImmutable $jour,
        AnneeScolaires $anneeScolaire,
        ?int $excludeId = null
    ): ?Indiscipline {
        $qb = $this->createQueryBuilder('i')
        ->where('i.eleve = :eleve')
        ->andWhere('i.jour = :jour')
        ->andWhere('i.anneeScolaire = :anneeScolaire');
    
    $qb->setParameter('eleve', $eleve)
       ->setParameter('jour', $jour)
       ->setParameter('anneeScolaire', $anneeScolaire);
    
    if ($excludeId !== null) {
        $qb->andWhere('i.id != :id')->setParameter('id', $excludeId);
    }
    
    return $qb->getQuery()->getOneOrNullResult();
    
    }

//    /**
//     * @return Indiscipline[] Returns an array of Indiscipline objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Indiscipline
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
