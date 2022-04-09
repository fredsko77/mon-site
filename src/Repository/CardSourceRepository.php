<?php

namespace App\Repository;

use App\Entity\CardSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CardSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardSource[]    findAll()
 * @method CardSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardSource::class);
    }

    // /**
    //  * @return CardSource[] Returns an array of CardSource objects
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
    public function findOneBySomeField($value): ?CardSource
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
