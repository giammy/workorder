<?php

namespace App\Repository;

use App\Entity\Workslist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Workslist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workslist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workslist[]    findAll()
 * @method Workslist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkslistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workslist::class);
    }

    // /**
    //  * @return Workslist[] Returns an array of Workslist objects
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
    public function findOneBySomeField($value): ?Workslist
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
