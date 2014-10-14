<?php
namespace inklabs\kommerce\Entity;

class AttributeValue
{
    use Accessor\Time;

    protected $id;
    protected $sku;
    protected $name;
    protected $description;
    protected $sortOrder;

    public function getId()
    {
        return $this->id;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getSku()
    {
        return $this->sku;
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
}
