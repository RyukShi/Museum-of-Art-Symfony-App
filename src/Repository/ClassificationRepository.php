<?php

namespace App\Repository;

use App\Entity\Classification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchData;

/**
 * @method Classification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classification[]    findAll()
 * @method Classification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classification::class);
    }

    /**
     * Retrieves artists related to a search
     * @param SearchData $search
     */
    public function findSearch(SearchData $search)
    {
        $query = $this
            ->createQueryBuilder('c')
            ->select('c');

        if (!empty($search->classification)) {
            $query
                ->andWhere('c.classification LIKE :classification')
                ->setParameter('classification', "%{$search->classification}%");
        }

        $query->orderBy('c.classification', 'ASC');

        return ($query->getQuery())->getResult();
    }

    // /**
    //  * @return Classification[] Returns an array of Classification objects
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
    public function findOneBySomeField($value): ?Classification
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
