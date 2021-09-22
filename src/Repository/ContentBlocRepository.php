<?php

namespace App\Repository;

use App\Entity\ContentBloc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContentBloc|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentBloc|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentBloc[]    findAll()
 * @method ContentBloc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentBlocRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentBloc::class);
    }

    // /**
    //  * @return ContentBloc[] Returns an array of ContentBloc objects
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
    public function findOneBySomeField($value): ?ContentBloc
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
