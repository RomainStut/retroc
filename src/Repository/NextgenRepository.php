<?php

namespace App\Repository;

use App\Entity\Nextgen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Nextgen|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nextgen|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nextgen[]    findAll()
 * @method Nextgen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NextgenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Nextgen::class);
    }

//    /**
//     * @return Nextgen[] Returns an array of Nextgen objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nextgen
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
