<?php

namespace App\Repository;

use App\Entity\FileExtension;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FileExtension|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileExtension|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileExtension[]    findAll()
 * @method FileExtension[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileExtensionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileExtension::class);
    }

    // /**
    //  * @return FileExtension[] Returns an array of FileExtension objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileExtension
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
