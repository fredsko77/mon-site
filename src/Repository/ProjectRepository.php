<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{

    /**
     * @var Security $security
     */
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Project::class);
        $this->security = $security;
    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function findHomePageProjects()
    {
        $query = $this->createQueryBuilder('p');

        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $query->andWhere('p.visibility = \'public\'');
        }

        return $query
            ->orderBy('p.created_at', 'desc')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
public function findOneBySomeField($value): ?Project
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
