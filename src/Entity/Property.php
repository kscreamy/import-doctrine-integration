<?php

namespace Screamy\PriceImporter\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Property
 * @package Screamy\PriceImporter\Entity
 */
class Property
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $propertyValues;

    /**
     * Property constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->propertyValues = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPropertyValues()
    {
        return $this->propertyValues;
    }
}
