<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\Query;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    /**
    * this function return the Query of select all product
    *
    * @return Query
    */
    public function findAllUserQuery():Query
    {
        return $this->createQueryBuilder('bp')
        ->getQuery()
        ;
    }
    public function findAllByCustomerIdQuery($value): ?Query
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.customer = :val')
            ->setParameter('val', $value)
            ->getQuery()
            
        ;
    }
}
