<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Attribute
{
    use Accessor\Time;

    protected $id;
    protected $name;
    protected $description;
    protected $sortOrder;

    protected $attributeValues;

    public function __construct()
    {
        $this->setCreated();
        $this->attributeValues = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function addAttributeValue(AttributeValue $attributeValue)
    {
        $this->attributeValues[] = $attributeValue;
    }

    public function getAttributeValues()
    {
        return $this->attributeValues;
    }
}
