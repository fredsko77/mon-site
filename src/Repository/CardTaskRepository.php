<?php

namespace App\Repository;

use App\Entity\CardTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CardTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardTask[]    findAll()
 * @method CardTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardTask::class);
    }

    // /**
    //  * @return CardTask[] Returns an array of CardTask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CardTask
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
