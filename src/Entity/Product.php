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
    private $id;
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
     * @var string
     */
    private $imagePath;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var Brand
     */
    private $brand;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     * @return $this
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     * @return $this
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
        return $this;
    }
}
