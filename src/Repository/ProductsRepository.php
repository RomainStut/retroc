<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Products::class);
    }

    /**
     * @param $id
     * @return mixed
     */

    public function myFind($id)
    {
        $querybuilder = $this->createQuerybuilder('p')
            ->innerJoin('p.user', 'u')
            ->addSelect('u')
            ->innerJoin('p.categorie', 'c')
            ->addSelect('c')
            ->innerJoin('p.quality', 'q')
            ->addSelect('q')
            ->innerJoin('p.type', 't')
            ->addSelect('t')
            ->andWhere('p.id = :id')
            ->setparameter('id', $id)
            ->setMaxResults(1)
            ->getQuery();

        return $querybuilder->execute();
    }
//    /**
//     * @return Products[] Returns an array of Products objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Products
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
