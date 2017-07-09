<?php

namespace Screamy\PriceImporter\Entity;

use Doctrine\Common\Annotations as ORM;

/**
 * Class Category
 * @package Screamy\PriceImporter\Entity
 * @ORM\Entity(table="category")
 */
class Category
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Category
     * @ORM\Column(type="integer", name="parent_id", nullable=true)
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
    */
    private $parent;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
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
