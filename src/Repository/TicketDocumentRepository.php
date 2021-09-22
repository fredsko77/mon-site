<?php

namespace App\Repository;

use App\Entity\TicketDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TicketDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketDocument[]    findAll()
 * @method TicketDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketDocument::class);
    }

    // /**
    //  * @return TicketDocument[] Returns an array of TicketDocument objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TicketDocument
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
