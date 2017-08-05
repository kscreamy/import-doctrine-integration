<?php

namespace Screamy\PriceImporter\Utils;

use Doctrine\ORM\EntityManager;
use Screamy\PriceImporter\Entity\Brand;
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
            throw new \LogicException('Product with sku ' . $model->getSku() . ' already exists');
        }

        /**
         * @var Category $category
         */
        $category = $this->entityManager->find(Category::class, $model->getCategoryId());

        if (!$category) {
            return;//category is not imported now
        }

        $this->entityManager->beginTransaction();

        try {
            $product = new Product($model->getSku());

            $product->setTitle($model->getTitle())
                ->setImorted(false)
                ->setCategory($category)
                ->setImages($model->getImages() ? $model->getImages() : null)
                ->setPrice($this->getFirstPriceInfo($model->getPrices())->getPrice())
                ->setQuantity($model->getCount() ? $model->getCount() : 0);

            /**
             * @var ProductPropertyModel $propertyModel
             */
            foreach ($model->getProperties() as $propertyModel) {
                if ($propertyModel->getValue() == '') {
                    continue;
                }
                $product->addProperty($this->getProductProperty($propertyModel));
            }

            if ($model->getBrand()) {
                $product->setBrand($this->getBrand($model));
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

    /**
     * @param ProductModel $product
     * @return Brand
     */
    private function getBrand(ProductModel $product)
    {
        $brandRepository = $this->entityManager->getRepository(Brand::class);

        $brand = $brandRepository->findOneBy(['title' => $product->getBrand()]);
        if (!$brand) {
            $brand = new Brand();
            $brand->setTitle($product->getBrand());
            $this->entityManager->persist($brand);
        }

        return $brand;
    }
}
