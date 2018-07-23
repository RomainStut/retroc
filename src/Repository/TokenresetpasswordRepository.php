<?php

namespace App\Repository;

use App\Entity\Tokenresetpassword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tokenresetpassword|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tokenresetpassword|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tokenresetpassword[]    findAll()
 * @method Tokenresetpassword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenresetpasswordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tokenresetpassword::class);
    }

//    /**
//     * @return Tokenresetpassword[] Returns an array of Tokenresetpassword objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tokenresetpassword
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
