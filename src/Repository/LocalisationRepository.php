<?php

namespace App\Repository;

use App\Entity\Localisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchData;

/**
 * @method Localisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localisation[]    findAll()
 * @method Localisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Localisation::class);
    }

    /**
     * Retrieves localisations related to a search
     * @param SearchData $search
     */
    public function findSearch(SearchData $search)
    {
        $query = $this
            ->createQueryBuilder('l')
            ->select('l');

        if (!empty($search->culture)) {
            $query
                ->andWhere('l.culture LIKE :culture')
                ->setParameter('culture', "%{$search->culture}%");
        }

        if (!empty($search->period)) {
            $query
                ->andWhere('l.period LIKE :period')
                ->setParameter('period', "%{$search->period}%");
        }

        if (!empty($search->dynasty)) {
            $query
                ->andWhere('l.dynasty LIKE :dynasty')
                ->setParameter('dynasty', "%{$search->dynasty}%");
        }

        if (!empty($search->reign)) {
            $query
                ->andWhere('l.reign LIKE :reign')
                ->setParameter('reign', "%{$search->reign}%");
        }

        if (!empty($search->region)) {
            $query
                ->andWhere('l.region LIKE :region')
                ->setParameter('region', "%{$search->region}%");
        }

        if (!empty($search->subregion)) {
            $query
                ->andWhere('l.subregion LIKE :subregion')
                ->setParameter('subregion', "%{$search->subregion}%");
        }

        if (!empty($search->country)) {
            $query
                ->andWhere('l.country LIKE :country')
                ->setParameter('country', "%{$search->country}%");
        }

        if (!empty($search->county)) {
            $query
                ->andWhere('l.county LIKE :county')
                ->setParameter('county', "%{$search->county}%");
        }

        if (!empty($search->city)) {
            $query
                ->andWhere('l.city LIKE :city')
                ->setParameter('city', "%{$search->city}%");
        }

        if (!empty($search->locale)) {
            $query
                ->andWhere('l.locale LIKE :locale')
                ->setParameter('locale', "%{$search->locale}%");
        }

        if (!empty($search->locus)) {
            $query
                ->andWhere('l.locus LIKE :locus')
                ->setParameter('locus', "%{$search->locus}%");
        }

        if (!empty($search->river)) {
            $query
                ->andWhere('l.river LIKE :river')
                ->setParameter('river', "%{$search->river}%");
        }

        if (!empty($search->excavation)) {
            $query
                ->andWhere('l.excavation LIKE :excavation')
                ->setParameter('excavation', "%{$search->excavation}%");
        }

        if ($search->offset >= 0 && $search->limit >= 1 && $search->limit <= 30000) {
            $query->setFirstResult($search->offset);
            $query->setMaxResults($search->limit);
        }

        $query->orderBy('l.city', 'ASC');

        return ($query->getQuery())->getResult();
    }

    // /**
    //  * @return Localisation[] Returns an array of Localisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Localisation
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
