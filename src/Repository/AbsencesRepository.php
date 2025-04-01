<?php

namespace App\Repository;

use App\Entity\Eleves;
use App\Entity\Absences;
use App\Entity\AnneeScolaires;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Absences>
 */
class AbsencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absences::class);
    }

    public function findExistingAbsence(
        Eleves $eleve,
        \DateTimeImmutable $jour,
        AnneeScolaires $anneeScolaire,
        ?int $excludeId = null
    ): ?Absences {
        $qb = $this->createQueryBuilder('a')
        ->where('a.eleve = :eleve')
        ->andWhere('a.jour = :jour')
        ->andWhere('a.anneeScolaire = :anneeScolaire')
        ->andWhere('a.heure IS NOT NULL');
    
    $qb->setParameter('eleve', $eleve)
       ->setParameter('jour', $jour)
       ->setParameter('anneeScolaire', $anneeScolaire);
    
    if ($excludeId !== null) {
        $qb->andWhere('a.id != :id')->setParameter('id', $excludeId);
    }
    
    return $qb->getQuery()->getOneOrNullResult();
    
    }

    //    /**
    //     * @return Absences[] Returns an array of Absences objects
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

    //    public function findOneBySomeField($value): ?Absences
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
