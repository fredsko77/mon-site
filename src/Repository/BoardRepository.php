<?php

namespace App\Repository;

use App\Entity\Board;
use App\Entity\Card;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Board|null find($id, $lockMode = null, $lockVersion = null)
 * @method Board|null findOneBy(array $criteria, array $orderBy = null)
 * @method Board[]    findAll()
 * @method Board[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Board::class);
    }

    public function findRoomFilteredBoards(Room $room, bool $state, ?string $sort)
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.room = :room')
            ->andWhere('b.isOpen = :state')
            ->setParameter('state', $state)
            ->setParameter('room', $room)
        ;

        if ($sort !== null) {
            if ($sort === 'recently-created') {
                $qb->orderBy('b.created_at', 'desc');
            } elseif ($sort === 'recently-updated') {
                $qb->orderBy('b.updated_at', 'desc');
            } elseif ($sort === 'closest-deadline') {
                $qb->orderBy('b.deadline', 'desc');
            } elseif ($sort === 'furthest-deadline') {
                $qb->orderBy('b.deadline', 'desc');
            } elseif ($sort === 'most-cards') {
                $query = $this->createQueryBuilder('b');
                $query
                    ->select('b, COUNT(b) AS nb_cards_open')
                    ->leftJoin(
                        Card::class, 'c', Join::WITH, 'b = c.board'
                    )
                    ->where('c.isOpen = :cardState')
                    ->andWhere('b.isOpen = :state')
                    ->andWhere('b.room = :room')
                    ->setParameters([
                        'room' => $room,
                        'cardState' => true,
                        'state' => $state,
                    ])
                    ->groupBy('b.id')
                    ->orderBy('nb_cards_open', 'DESC')
                ;

                return $query->getQuery()->getResult();
            } elseif ($sort === 'least-cards') {
                $query = $this->createQueryBuilder('b');
                $query
                    ->select('b, COUNT(b) AS nb_cards_open')
                    ->leftJoin(
                        Card::class, 'c', Join::WITH, 'b = c.board'
                    )
                    ->where('c.isOpen = :cardState')
                    ->andWhere('b.isOpen = :state')
                    ->andWhere('b.room = :room')
                    ->setParameters([
                        'room' => $room,
                        'cardState' => true,
                        'state' => $state,
                    ])
                    ->groupBy('b.id')
                    ->orderBy('nb_cards_open', 'ASC')
                ;

                return $query->getQuery()->getResult();
            }
        }

        return $qb->getQuery()
            ->getResult()
        ;

    }

    // /**
    //  * @return Board[] Returns an array of Board objects
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
public function findOneBySomeField($value): ?Board
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
