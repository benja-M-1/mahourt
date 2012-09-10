<?php

namespace Mahourt\StockBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class ProductRepository extends EntityRepository
{
    /**
     * @param string $search
     * @return array
     */
    public function findLike($search)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->where(
            $qb->expr()->like(
                'p.name',
                $qb->expr()->literal($search.'%')
            )
        );

        return $qb->getQuery()->getResult();
    }
}
