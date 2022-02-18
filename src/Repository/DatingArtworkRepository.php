<?php

namespace App\Repository;

use App\Entity\DatingArtwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DatingArtwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatingArtwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatingArtwork[]    findAll()
 * @method DatingArtwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatingArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatingArtwork::class);
    }

    // /**
    //  * @return DatingArtwork[] Returns an array of DatingArtwork objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DatingArtwork
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
