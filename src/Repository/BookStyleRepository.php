<?php

namespace App\Repository;

use App\Entity\BookStyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookStyle|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookStyle|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookStyle[]    findAll()
 * @method BookStyle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookStyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookStyle::class);
    }

    // /**
    //  * @return BookStyle[] Returns an array of BookStyle objects
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
    public function findOneBySomeField($value): ?BookStyle
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
