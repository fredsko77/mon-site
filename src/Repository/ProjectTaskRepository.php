<?php

namespace App\Repository;

use App\Entity\ProjectTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTask[]    findAll()
 * @method ProjectTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectTask::class);
    }

    // /**
    //  * @return ProjectTask[] Returns an array of ProjectTask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectTask
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
