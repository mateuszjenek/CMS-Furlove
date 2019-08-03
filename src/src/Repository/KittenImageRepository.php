<?php

namespace App\Repository;

use App\Entity\KittenImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method KittenImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method KittenImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method KittenImage[]    findAll()
 * @method KittenImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KittenImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, KittenImage::class);
    }

    // /**
    //  * @return KittenImage[] Returns an array of KittenImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KittenImage
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
