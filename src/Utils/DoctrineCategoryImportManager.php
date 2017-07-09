<?php

namespace Screamy\PriceImporter\Utils;

use Doctrine\ORM\EntityManager;
use Screamy\PriceImporter\Entity\Category;
use Screamy\PriceImporter\Gateway\CategoryGatewayInterface;
use Screamy\PriceImporter\Mapper\CategoryIterator;
use Screamy\PriceImporter\Model\Category as CategoryModel;

/**
 * Class DoctrineCategoryImportManager
 * @package Screamy\PriceImporter\Utils
 */
class DoctrineCategoryImportManager implements CategoryGatewayInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CategoryImportManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function emitCategories(CategoryIterator $categories)
    {
        $this->saveCategories($categories);

    }

    /**
     * @param CategoryIterator $categories
     * @throws \Exception
     */
    private function saveCategories(CategoryIterator $categories)
    {
        $this->entityManager->beginTransaction();
        try {
            $categoryRepository = $this->entityManager->getRepository(Category::class);
            /**
             * @var CategoryModel $categoryModel
             */
            foreach ($categories as $categoryModel) {
                /**
                 * @var Category $category
                 */
                $category = $categoryRepository->find($categoryModel->getId());
                if (!$category) {
                    $category = new Category($categoryModel->getId());
                    $category->setTitle($categoryModel->getTitle());
                    $this->entityManager->persist($category);
                }
            }
            /**
             * @var CategoryModel $categoryModel
             * all categories saved set all parents
             */
            foreach ($categories as $categoryModel) {
                /**
                 * @var Category $category
                 */
                $category = $categoryRepository->find($categoryModel->getId());
                $parentCategory = $categoryRepository->find($categoryModel->getParentId());
                if (!$category->getParent() && $parentCategory) {
                    $category->setParent($parentCategory);
                }
            }
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
