<?php

namespace App\Repository;

use App\Entity\BoardType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoardType|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardType|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardType[]    findAll()
 * @method BoardType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardType::class);
    }

    // /**
    //  * @return BoardType[] Returns an array of BoardType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BoardType
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
