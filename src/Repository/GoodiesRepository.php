<?php

namespace App\Repository;

use App\Entity\Goodies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Goodies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Goodies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Goodies[]    findAll()
 * @method Goodies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoodiesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Goodies::class);
    }

//    /**
//     * @return Goodies[] Returns an array of Goodies objects
//     */
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
    public function findOneBySomeField($value): ?Goodies
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
