<?php

namespace App\Service;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;

class FruitService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFruits(?string $nameFilter, ?string $familyFilter, int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $qb = $this->entityManager->createQueryBuilder()
            ->select('f')
            ->from(Fruit::class, 'f');




        if ($nameFilter) {
            $qb->andWhere('f.name LIKE :nameFilter')
                ->setParameter('nameFilter', "%$nameFilter%");
        }

        if ($familyFilter) {
            $qb->andWhere('f.family LIKE :familyFilter')
                ->setParameter('familyFilter', "%$familyFilter%");
        }


        // get the total count without limit and offset
        $countQuery = clone $qb;
        $countQuery->select('COUNT(f.id)');
        $count = $countQuery->getQuery()->getSingleScalarResult();


        $qb->setMaxResults($limit)
            ->setFirstResult($offset);

        $fruits = $qb->getQuery()->getResult();



        return [
            'fruits' => $fruits,
            'count' => $count
        ];
    }
}
