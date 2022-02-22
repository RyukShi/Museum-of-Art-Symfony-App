<?php

namespace App\Repository;

use App\Entity\DatingArtwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchData;

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

    /**
     * Retrieves artists related to a search
     * @param SearchData $search
     */
    public function findSearch(SearchData $search)
    {
        $query = $this
            ->createQueryBuilder('d')
            ->select('d');

        if (!empty($search->object_date)) {
            $query
                ->andWhere('d.object_date LIKE :object_date')
                ->setParameter('object_date', "%{$search->object_date}%");
        }

        if (!empty($search->object_begin_date)) {
            $query
                ->andWhere('d.object_begin_date >= :object_begin_date')
                ->setParameter('object_begin_date', $search->object_begin_date);
        }

        if (!empty($search->object_end_date)) {
            $query
                ->andWhere('d.object_end_date <= :object_end_date')
                ->setParameter('object_end_date', $search->object_end_date);
        }

        $query->orderBy('d.object_date', 'ASC');

        return ($query->getQuery())->getResult();
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
