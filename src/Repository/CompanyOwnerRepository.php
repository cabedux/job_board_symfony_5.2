<?php

namespace App\Repository;

use App\Entity\CompanyOwner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyOwner|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyOwner|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyOwner[]    findAll()
 * @method CompanyOwner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyOwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyOwner::class);
    }

    // /**
    //  * @return CompanyOwner[] Returns an array of CompanyOwner objects
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
    public function findOneBySomeField($value): ?CompanyOwner
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
