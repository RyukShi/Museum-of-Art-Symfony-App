<?php

namespace App\Repository;

use App\Entity\Artwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchData;

/**
 * @method Artwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artwork[]    findAll()
 * @method Artwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
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

        if (!empty($search->number)) {
            $query
                ->andWhere('a.number LIKE :number')
                ->setParameter('number', "%{$search->number}%");
        }

        if (!empty($search->name)) {
            $query
                ->andWhere('a.name LIKE :name')
                ->setParameter('name', "%{$search->name}%");
        }

        if (!empty($search->title)) {
            $query
                ->andWhere('a.title LIKE :title')
                ->setParameter('title', "%{$search->title}%");
        }

        if (!empty($search->dimensions)) {
            $query
                ->andWhere('a.dimensions LIKE :dimensions')
                ->setParameter('dimensions', "%{$search->dimensions}%");
        }

        if (!empty($search->medium)) {
            $query
                ->andWhere('a.medium LIKE :medium')
                ->setParameter('medium', "%{$search->medium}%");
        }

        $query->orderBy('a.title', 'ASC');

        return ($query->getQuery())->getResult();
    }

    // /**
    //  * @return Artwork[] Returns an array of Artwork objects
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
    public function findOneBySomeField($value): ?Artwork
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
