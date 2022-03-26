<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Chapter;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Security;

/**
 * @method Chapter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chapter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chapter[]    findAll()
 * @method Chapter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChapterRepository extends ServiceEntityRepository
{

    /**
     * @var Security $security
     */
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Chapter::class);
        $this->security = $security;
    }

    
    /**
     * Find Book Chapters
     *
     * @param Book $book
     * 
     * @return Chapter[]|null
     */
    public function findBookChapters(Book $book)
    {
        $query = $this->createQueryBuilder('c');
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $query->where('c.visibility = :visibility')
            ->setParameter('visibility', Chapter::VISIBILITY_PUBLIC);
        }
        
        return $query->andWhere('c.book = :book')
            ->setParameter('book', $book)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Chapter[] Returns an array of Chapter objects
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
    public function findOneBySomeField($value): ?Chapter
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
