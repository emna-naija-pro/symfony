<?php

namespace App\Repository;

use App\Entity\Aaa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Aaa>
 *
 * @method Aaa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aaa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aaa[]    findAll()
 * @method Aaa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AaaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aaa::class);
    }

//    /**
//     * @return Aaa[] Returns an array of Aaa objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Aaa
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
