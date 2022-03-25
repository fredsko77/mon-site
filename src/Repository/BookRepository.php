<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Shelf;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    /**
     * @var Security $security
     */
    private $security;
    
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Book::class);
        $this->security = $security;
    }

    /**
     * @param Shelf $shelf
     *
     * @return Book[]
     */
    public function findShelfBooks(Shelf $shelf)
    {
        $query = $this->createQueryBuilder('s');
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $query->where('s.visibility = :visibility')
            ->setParameter('visibility', Book::VISIBILITY_PUBLIC);
        }
        
        return $query->andWhere('s.shelf = :shelf')
            ->setParameter('shelf', $shelf)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
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
public function findOneBySomeField($value): ?Book
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
