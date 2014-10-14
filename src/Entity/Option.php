<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Option
{
    use Accessor\Time;

    protected $id;
    protected $name;
    protected $type; // select, radio, checkbox, text, textarea, file, date, time, datetime
    protected $description;
    protected $sortOrder;

    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection;
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

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function getProducts()
    {
        return $this->products;
    }
}
