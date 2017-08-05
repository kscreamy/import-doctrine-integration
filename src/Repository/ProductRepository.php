<?php

namespace Screamy\PriceImporter\Repository;

use Doctrine\ORM\EntityRepository;
use Screamy\PriceImporter\Entity\Product;

/**
 * Class ProductRepository
 * @package Screamy\PriceImporter\Repository
 */
class ProductRepository extends EntityRepository
{
    /**
     * @param string $sku
     * @return null|Product
     */
    public function findProductBySku($sku)
    {
        return $this->findOneBy(['sku' => $sku]);
    }

    public function getProductsByIds(array $ids)
    {
        $qb =$this->createQueryBuilder('p');
        $qb->where($qb->expr()->in('p.id', $ids));

        return $qb->getQuery()->getResult();
    }
}
