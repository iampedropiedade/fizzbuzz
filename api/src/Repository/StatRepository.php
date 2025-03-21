<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Stat;
use App\Query\FizzBuzzQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stat>
 */
class StatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stat::class);
    }

    public function findTopRequest(): ?Stat
    {
        return $this
            ->createQueryBuilder('s')
            ->orderBy('s.count', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByQuery(FizzBuzzQuery $query): ?Stat
    {
        return $this
            ->createQueryBuilder('s')
            ->where('s.numberLimit = :numberLimit')
            ->setParameter('numberLimit', $query->getLimit())
            ->andWhere('s.number1 = :number1')
            ->setParameter('number1', $query->getNumber1())
            ->andWhere('s.number2 = :number2')
            ->setParameter('number2', $query->getNumber2())
            ->andWhere('s.string1 = :string1')
            ->setParameter('string1', $query->getString1())
            ->andWhere('s.string2 = :string2')
            ->setParameter('string2', $query->getString2())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function incrementStat(FizzBuzzQuery $query): void
    {
        $stat = $this->findByQuery($query) ??
            new Stat(
                $query->getLimit(),
                $query->getNumber1(),
                $query->getNumber2(),
                $query->getString1(),
                $query->getString2()
            );
        $stat->incrementCount();
        $this->getEntityManager()->persist($stat);
        $this->getEntityManager()->flush();
    }
}
