<?php

namespace App\Repository;

use App\Entity\BoardTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoardTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardTag[]    findAll()
 * @method BoardTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardTag::class);
    }

    // /**
    //  * @return BoardTag[] Returns an array of BoardTag objects
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
    public function findOneBySomeField($value): ?BoardTag
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
