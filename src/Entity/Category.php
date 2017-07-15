<?php

namespace Screamy\PriceImporter\Entity;

use Doctrine\Common\Annotations as ORM;

/**
 * Class Category
 * @package Screamy\PriceImporter\Entity
 */
class Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Category
     */
    private $parent;

    /**
     * @var string
     */
    private $title;

    /**
     * not implemented now
     * @todo implement
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * Category constructor.
     * @param $id
     * @param Category|null $parent
     */
    public function __construct($id, Category $parent = null)
    {
        $this->id = $id;
        $this->parent = $parent;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     * @return $this
     */
    public function setParent(Category $parent)
    {
        $this->parent = $parent;
        return $this;
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
     * @param $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
