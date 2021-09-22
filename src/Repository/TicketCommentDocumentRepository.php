<?php

namespace App\Repository;

use App\Entity\TicketCommentDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TicketCommentDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketCommentDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketCommentDocument[]    findAll()
 * @method TicketCommentDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketCommentDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketCommentDocument::class);
    }

    // /**
    //  * @return TicketCommentDocument[] Returns an array of TicketCommentDocument objects
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
    public function findOneBySomeField($value): ?TicketCommentDocument
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
