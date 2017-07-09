<?php

namespace Screamy\PriceImporter\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Product
 * @package Screamy\PriceImporter\Entity
 */
class Product
{
    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $title;

    /**
     * @var float
     */
    private $price;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var Collection
     */
    private $properties;

    /**
     * @var bool
     */
    private $imported;

    /**
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * Product constructor.
     * @param string $sku
     */
    public function __construct($sku)
    {
        $this->properties = new ArrayCollection();
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param PropertyValue $property
     * @return $this
     */
    public function addProperty(PropertyValue $property)
    {
        $this->properties->add($property);
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param bool $imported
     * @return $this
     */
    public function setImorted($imported)
    {
        $this->imported = $imported;
        return $this;
    }

    /**
     * @return bool
     */
    public function isImported()
    {
        return $this->imported;
    }
}
