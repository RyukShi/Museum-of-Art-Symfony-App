<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchData;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    /**
     * Retrieves artists related to a search
     * @param SearchData $search
     */
    public function findSearch(SearchData $search)
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('a');

        if (!empty($search->display_name)) {
            $query
                ->andWhere('a.display_name LIKE :display_name')
                ->setParameter('display_name', "%{$search->display_name}%");
        }

        if (!empty($search->begin_date)) {
            $query
                ->andWhere('a.begin_date LIKE :begin_date')
                ->setParameter('begin_date', "%{$search->begin_date}%");
        }

        if (!empty($search->end_date)) {
            $query
                ->andWhere('a.end_date LIKE :end_date')
                ->setParameter('end_date', "%{$search->end_date}%");
        }

        if (!empty($search->gender)) {
            $query
                ->andWhere('a.gender LIKE :gender')
                ->setParameter('gender', "%{$search->gender}%");
        }

        if (!empty($search->nationality)) {
            $query
                ->andWhere('a.nationality LIKE :nationality')
                ->setParameter('nationality', "%{$search->nationality}%");
        }

        $query->orderBy('a.display_name', 'ASC');

        return ($query->getQuery())->getResult();
    }

    // /**
    //  * @return Artist[] Returns an array of Artist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artist
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
