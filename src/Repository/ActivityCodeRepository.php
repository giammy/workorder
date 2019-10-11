<?php

namespace App\Repository;

use App\Entity\ActivityCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActivityCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityCode[]    findAll()
 * @method ActivityCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityCode::class);
    }

    // /**
    //  * @return ActivityCode[] Returns an array of ActivityCode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActivityCode
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
