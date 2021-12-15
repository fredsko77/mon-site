<?php

namespace App\Repository;

use App\Entity\GroupSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupSkill[]    findAll()
 * @method GroupSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupSkill::class);
    }

    // /**
    //  * @return GroupSkill[] Returns an array of GroupSkill objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('g')
    ->andWhere('g.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('g.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
public function findOneBySomeField($value): ?GroupSkill
{
return $this->createQueryBuilder('g')
->andWhere('g.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
 */
}
