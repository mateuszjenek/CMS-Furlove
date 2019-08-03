<?php

namespace App\Repository;

use App\Entity\CatImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CatImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatImage[]    findAll()
 * @method CatImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CatImage::class);
    }

    // /**
    //  * @return CatImage[] Returns an array of CatImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CatImage
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
