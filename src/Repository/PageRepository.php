<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Page;
use App\Entity\Chapter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    
    /**
     * @var Security $security
     */
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Page::class);
        $this->security = $security;
    }

    /**
     * Find Chapter Pages
     *
     * @param Chapter $chapter
     * 
     * @return Page[]|null
     */
    public function findChapterPages(Chapter $chapter)
    {
        $query = $this->createQueryBuilder('p');
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $query->where('p.visibility = :visibility')
            ->setParameter('visibility', Page::VISIBILITY_PUBLIC);
        }
        
        return $query->andWhere('p.chapter = :chapter')
            ->setParameter('chapter', $chapter)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find Book Pages
     *
     * @param Book $book
     * 
     * @return Page[]|null
     */
    public function findBookPages(Book $book)
    {
        $query = $this->createQueryBuilder('p');
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $query->where('p.visibility = :visibility')
            ->setParameter('visibility', Page::VISIBILITY_PUBLIC);
        }
        
        return $query->andWhere('p.book = :book')
            ->setParameter('book', $book)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Page[] Returns an array of Page objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Page
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
