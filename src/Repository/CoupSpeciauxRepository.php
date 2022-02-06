<?php

namespace App\Repository;

use App\Entity\CoupSpeciaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoupSpeciaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoupSpeciaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoupSpeciaux[]    findAll()
 * @method CoupSpeciaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoupSpeciauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoupSpeciaux::class);
    }

    // /**
    //  * @return CoupSpeciaux[] Returns an array of CoupSpeciaux objects
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
    public function findOneBySomeField($value): ?CoupSpeciaux
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
