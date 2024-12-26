<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * @return Person[] Returns an array of Person objects
     */
    public function findByOldInterval(int $oldMin, int $oldMax): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.old >= :oldMin and p.old <= :oldMax')
            /*->setParameter('oldMin', $oldMin)
            ->setParameter('oldMax', $oldMax)*/
            ->setParameters(new ArrayCollection([
                new Parameter('oldMin', $oldMin),
                new Parameter('oldMax', $oldMax)
            ]))
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Person
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
