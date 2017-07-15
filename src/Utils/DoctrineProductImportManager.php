<?php

namespace Screamy\PriceImporter\Utils;

use Doctrine\ORM\EntityManager;
use Screamy\PriceImporter\Entity\Category;
use Screamy\PriceImporter\Entity\Product;
use Screamy\PriceImporter\Entity\Property;
use Screamy\PriceImporter\Entity\PropertyValue;
use Screamy\PriceImporter\Exception\ProductNotFoundException;
use Screamy\PriceImporter\Model\Product as ProductModel;
use Screamy\PriceImporter\Model\Product\ProductProperty as ProductPropertyModel;
use Screamy\PriceImporter\Repository\ProductRepository;

/**
 * Class DoctrineImportManager
 * @package Screamy\PriceImporter\Utils
 */
class DoctrineProductImportManager implements ProductPricesImportManagerInterface, ProductImportManagerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DoctrineImportManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function importProduct(ProductModel $model)
    {
        /**
         * @var ProductRepository $productRepository
         */
        $productRepository = $this->entityManager->getRepository(Product::class);

        if ($productRepository->findOneBy(['sku' => $model->getSku()])) {
            throw new \LogicException('Product with sku ' . $product->getSku() . ' already exists');
        }

        $category = $this->entityManager->find(Category::class, $model->getCategoryId());

        if (!$category) {
            return ;//category is not imported now
            //throw new \LogicException('Category with id ' . $model->getCategoryId() . ' not found');
        }

        $this->entityManager->beginTransaction();

        try {
            $product = new Product($model->getSku());

            $product->setTitle($model->getTitle())
                ->setImorted(false)
                ->setCategory($category)
                ->setPrice($this->getFirstPriceInfo($model->getPrices())->getPrice());

            /**
             * @var ProductPropertyModel $propertyModel
             */
            foreach ($model->getProperties() as $propertyModel) {
                if ($propertyModel->getValue() == '') {
                    continue;
                }
                $product->addProperty($this->getProductProperty($propertyModel));
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function importProductPrices($sku, array $prices)
    {
        /**
         * @var ProductRepository $productRepository
         */
        $productRepository = $this->entityManager->getRepository(Product::class);

        $product = $productRepository->findProductBySku($sku);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $product->setPrice($this->getFirstPriceInfo($prices)->getPrice());

        $this->entityManager->flush();
    }

    /**
     * @param array $prices
     * @return ProductModel\ProductPrice
     */
    private function getFirstPriceInfo(array $prices)
    {
        /**
         * @var ProductModel\ProductPrice $price
         */
        //now only the first price
        $price = array_pop($prices);
        return $price;
    }

    /**
     * @param ProductPropertyModel $model
     * @return PropertyValue
     */
    private function getProductProperty(ProductPropertyModel $model)
    {
        $propertyRepository = $this->entityManager->getRepository(Property::class);

        /**
         * @var Property|null
         */
        $property = $propertyRepository->findOneBy(['name' => $model->getTitle()]);
        if (!$property) {
            $property = new Property($model->getTitle());
            $this->entityManager->persist($property);
        }

        $propertyValueRepository = $this->entityManager->getRepository(PropertyValue::class);
        $propertyValue = $propertyValueRepository->findOneBy(['value' => $model->getValue()]);

        if (!$propertyValue) {
            $propertyValue = new PropertyValue($property, $model->getValue());
            $this->entityManager->persist($propertyValue);
        }

        return $propertyValue;
    }
}
