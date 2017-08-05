<?php

namespace Screamy\PriceImporter\Repository;

use Doctrine\ORM\EntityRepository;
use Screamy\PriceImporter\Entity\Product;

/**
 * Class CategoryRepository
 * @package Screamy\PriceImporter\Repository
 */
class CategoryRepository extends EntityRepository
{
    /**
     * @param $parentId
     * @return array
     */
    public function findByParentId($parentId) {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->where($parentId ? $qb->expr()->eq('c.parent_id', $parentId) : $qb->expr()->isNull('c.parent'))
            ->getQuery()
            ->getResult();
    }
}
