<?php

namespace App\Repository;

use App\Entity\Board;
use App\Entity\Card;
use App\Entity\CardNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    public function findBoardFilteredCards(Board $board, bool $state, ?string $sort, ?string $tag, ?string $search)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.board = :board')
            ->andWhere('c.isOpen = :state')
            ->setParameter('state', $state)
            ->setParameter('board', $board)
        ;

        if ($sort !== null) {
            if ($sort === 'recently-created') {
                $qb->orderBy('c.createdAt', 'desc');
            } elseif ($sort === 'oldest') {
                $qb->orderBy('c.createdAt', 'asc');
            } elseif ($sort === 'recently-updated') {
                $qb->orderBy('c.updatedAt', 'desc');
            } elseif ($sort === 'closest-deadline') {
                $qb->orderBy('c.deadline', 'desc');
            } elseif ($sort === 'furthest-deadline') {
                $qb->orderBy('c.deadline', 'asc');
            } elseif ($sort === 'most-notes') {
                $query = $this->createQueryBuilder('c');
                $query
                    ->select('c, COALESCE(COUNT(c), 0) AS nb_notes')
                    ->leftJoin(
                        CardNote::class, 'n', Join::WITH, 'c = n.card'
                    )
                    ->andWhere('c.isOpen = :state')
                    ->andWhere('c.board = :board')
                    ->setParameters([
                        'board' => $board,
                        'state' => $state,
                    ])
                    ->groupBy('c.id')
                    ->orderBy('nb_notes', 'desc')
                ;

                return $query->getQuery()->getResult();
            } elseif ($sort === 'least-notes') {
                $query = $this->createQueryBuilder('c');
                $query
                    ->select('c, COALESCE(COUNT(c), 0) AS nb_notes')
                    ->leftJoin(
                        CardNote::class, 'n', Join::WITH, 'c = n.card'
                    )
                    ->andWhere('c.isOpen = :state')
                    ->andWhere('c.board = :board')
                    ->setParameters([
                        'board' => $board,
                        'state' => $state,
                    ])
                    ->groupBy('c.id')
                    ->orderBy('nb_notes', 'ASC')
                ;

                return $query->getQuery()->getResult();
            }
        }

        return $qb->getQuery()
            ->getResult()
        ;

    }

    // /**
    //  * @return Card[] Returns an array of Card objects
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
public function findOneBySomeField($value): ?Card
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
