<?php

namespace Screamy\PriceImporter\Entity;

use Screamy\PriceImporter\Entity\Property;

/**
 * Class PropertyValue
 * @package Screamy\PriceImporter\Entity
 */
class PropertyValue
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Property
     */
    private $property;

    /**
     * @var string
     */
    private $value;

    /**
     * PropertyValue constructor.
     * @param Property $property
     * @param string $value
     */
    public function __construct(Property $property, $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
