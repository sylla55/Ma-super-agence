<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySeach;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @return Property[]
     */
    public function findAllVisible():array
    {
        return $this->createQueryBuilder('p')
                    ->where('p.sold = false')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @rerturn Query
     */
    public function findAllVisibleQuery(PropertySeach $seach)
    {
        $query = $this->createQueryBuilder('p')
                ->where('p.sold = false');
        
        if($seach->getMaxPrice()){
            $query = $query
            ->andwhere('p.price <= :maxprice')
            ->setParameter('maxprice', $seach->getMaxPrice());
        }

        if($seach->getMinSurface()){
            $query = $query
            ->andwhere('p.price >= :minsurface')
            ->setParameter('minsurface', $seach->getMinSurface());
        }

        return $query->getQuery();
    }

    /**
     * @return Property[]
     */
    public function findLatest():array
    {
        return $this->createQueryBuilder('p')
                    ->where('p.sold = false')
                    ->setMaxResults(4)
                    ->getQuery()
                    ->getResult();
    }


    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
