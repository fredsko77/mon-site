<?php

namespace App\Repository;

use App\Entity\CardNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CardNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardNote[]    findAll()
 * @method CardNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardNote::class);
    }

    // /**
    //  * @return CardNote[] Returns an array of CardNote objects
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
    public function findOneBySomeField($value): ?CardNote
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
