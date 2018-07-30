<?php

namespace App\Repository;

use App\Entity\TheMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TheMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method TheMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method TheMatch[]    findAll()
 * @method TheMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheMatchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TheMatch::class);
    }

//    /**
//     * @return TheMatch[] Returns an array of TheMatch objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TheMatch
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
