<?php

namespace App\Repository;

use App\Entity\Workorder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Workorder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workorder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workorder[]    findAll()
 * @method Workorder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkorderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workorder::class);
    }

    // /**
    //  * @return Workorder[] Returns an array of Workorder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Workorder
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
