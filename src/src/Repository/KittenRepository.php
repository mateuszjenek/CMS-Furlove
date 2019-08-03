<?php

namespace App\Repository;

use App\Entity\Kitten;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Kitten|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kitten|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kitten[]    findAll()
 * @method Kitten[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KittenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Kitten::class);
    }

    public function groupByLitter() {
        return $this->createQueryBuilder('k')
            ->orderBy('k.litter', 'DESC');
    }

    // /**
    //  * @return Kitten[] Returns an array of Kitten objects
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
    public function findOneBySomeField($value): ?Kitten
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
