<?php

namespace App\Repository;

use App\Entity\UserArtists;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserArtists|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserArtists|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserArtists[]    findAll()
 * @method UserArtists[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserArtistsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserArtists::class);
    }

    // /**
    //  * @return UserArtists[] Returns an array of UserArtists objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserArtists
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
