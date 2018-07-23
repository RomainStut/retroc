<?php

namespace App\Repository;

use App\Entity\Arcade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Arcade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arcade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arcade[]    findAll()
 * @method Arcade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArcadeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Arcade::class);
    }

//    /**
//     * @return Arcade[] Returns an array of Arcade objects
//     */
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
    public function findOneBySomeField($value): ?Arcade
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
