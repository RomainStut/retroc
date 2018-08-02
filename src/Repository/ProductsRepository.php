<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PhpParser\Comment\Doc;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

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

    public function myfindUserProducts($id)
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
             ->andWhere('p.user = :id')
             ->setparameter('id', $id)            
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

    private function createPaginator($query, $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(16);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    public function myFindAll(int $page = 1): Pagerfanta
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
                        ->andwhere('p.isvalidate = true')
                        ->getQuery();

        return $this->createPaginator($querybuilder, $page);

    }

    public function myFindLast4(){

        $querybuilder = $this->createQuerybuilder('p')
                        ->innerJoin('p.user', 'u')
                        ->addSelect('u')
                        ->innerJoin('p.categorie', 'c')
                        ->addSelect('c')
                        ->innerJoin('p.quality', 'q')
                        ->addSelect('q')
                        ->innerJoin('p.type', 't')
                        ->addSelect('t')
                        ->andwhere('p.isvalidate = true')
                        ->orderBy('p.datepost', 'DESC')
                        ->setMaxResults(4)
                        ->getQuery();

        return $querybuilder->execute();

    }

    public function findAllType($type, int $page = 1): Pagerfanta
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
                        ->andwhere('p.type = :type AND p.isvalidate = true')
                        ->setparameter('type', $type)
                        ->orderBy('p.datepost', 'DESC')
                        ->getQuery();

        return $this->createPaginator($querybuilder, $page);
    }

    public function findAllWhereTitlePagination($search, int $page = 1): Pagerfanta
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
            ->andWhere('p.name LIKE :search')
            ->setparameter('search', '%'.$search.'%')
            ->orderBy('p.datepost', 'DESC')
            ->getQuery();

        return $this->createPaginator($querybuilder, $page);

    }

    public function showAllTypeCat($type, $cat, int $page = 1): Pagerfanta
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
                        ->andwhere('p.categorie = :cat AND p.type = :type AND p.isvalidate = true')
                        ->setparameter('type', $type)
                        ->setparameter('cat', $cat)
                        ->orderBy('p.datepost', 'DESC')
                        ->getQuery();

        return $this->createPaginator($querybuilder, $page);
    }

    public function findInvalid(int $page): Pagerfanta
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
            ->andWhere('p.isvalidate = false')
            ->orderBy('p.datepost', 'DESC')
            ->setMaxResults(4)
            ->getQuery();

        return $this->createPaginator($querybuilder, $page);

    }

    public function findAllWhereTitle($search){

        $querybuilder = $this->createQuerybuilder('p')
            ->innerJoin('p.user', 'u')
            ->addSelect('u')
            ->innerJoin('p.categorie', 'c')
            ->addSelect('c')
            ->innerJoin('p.quality', 'q')
            ->addSelect('q')
            ->innerJoin('p.type', 't')
            ->addSelect('t')
            ->andWhere('p.name LIKE :search')
            ->setparameter('search', '%'.$search.'%')
            ->orderBy('p.datepost', 'DESC')
            ->getQuery();

        return $querybuilder->execute();

    }

    public function findAllWhereTitleQuality($search, $quality)
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
            ->andWhere('p.name LIKE :search AND p.quality = :quality')
            ->setparameter('search', '%'.$search.'%')
            ->setparameter('quality', $quality)
            ->getQuery();

        return $querybuilder->execute();

    }



}
