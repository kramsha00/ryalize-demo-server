<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    //    /**
    //     * @return Transaction[] Returns an array of Transaction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Transaction
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Fetch transactions based on filters with pagination.
     *
     * @param int|null $userId
     * @param int|null $locationId
     * @param \DateTime|null $startDate
     * @param \DateTime|null $endDate
     * @param int $page
     * @param int $limit
     * @return Transaction[]
     */
    public function findByFilters(
        ?int       $userId,
        ?int       $locationId,
        ?\DateTime $startDate,
        ?\DateTime $endDate,
        int        $page = 1,
        int        $limit = 10
    ): array
    {
        $qb = $this->createQueryBuilder('t')
            ->orderBy('t.date', 'DESC');

        // Apply filters
        if ($userId !== null) {
            $qb->andWhere('t.user = :userId')
                ->setParameter('userId', $userId);
        }

        if ($locationId !== null) {
            $qb->andWhere('t.location = :locationId')
                ->setParameter('locationId', $locationId);
        }

        if ($startDate !== null) {
            $qb->andWhere('t.date >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        if ($endDate !== null) {
            $qb->andWhere('t.date <= :endDate')
                ->setParameter('endDate', $endDate);
        }

        // Pagination
        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * Count the total number of transactions based on filters.
     *
     * @param int|null $userId
     * @param int|null $locationId
     * @param \DateTime|null $startDate
     * @param \DateTime|null $endDate
     * @return int
     */
    public function countByFilters(?int $userId, ?int $locationId, ?\DateTime $startDate, ?\DateTime $endDate): int
    {
        $qb = $this->createQueryBuilder('t')
            ->select('COUNT(t.id)');

        // Apply filters
        if ($userId !== null) {
            $qb->andWhere('t.user = :userId')
                ->setParameter('userId', $userId);
        }

        if ($locationId !== null) {
            $qb->andWhere('t.location = :locationId')
                ->setParameter('locationId', $locationId);
        }

        if ($startDate !== null) {
            $qb->andWhere('t.date >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        if ($endDate !== null) {
            $qb->andWhere('t.date <= :endDate')
                ->setParameter('endDate', $endDate);
        }

        return (int)$qb->getQuery()->getSingleScalarResult();
    }
}
