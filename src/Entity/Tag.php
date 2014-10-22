<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Tag
{
    use Accessor\Time;
    use OptionSelector;

    protected $id;
    protected $name;
    protected $description;
    protected $defaultImage;
    protected $isProductGroup;
    protected $sortOrder;
    protected $isVisible;
    protected $products;

    public function __construct()
    {
        $this->setCreated();
        $this->products = new ArrayCollection();
    }

    public function addProduct($product)
    {
        $this->products[] = $product;
    }

    public function getProducts()
    {
        return $this->products;
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

    public function setDefaultImage($defaultImage)
    {
        $this->defaultImage = $defaultImage;
    }

    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    public function getIsProductGroup()
    {
        return $this->isProductGroup;
    }

    public function setIsProductGroup($isProductGroup)
    {
        $this->isProductGroup = $isProductGroup;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    }

    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function getData()
    {
        $class = new \stdClass;
        $class->id             = $this->getId();
        $class->name           = $this->getName();
        $class->description    = $this->getDescription();
        $class->defaultImage   = $this->getDefaultImage();
        $class->isProductGroup = $this->getIsProductGroup();
        $class->sortOrder      = $this->getSortOrder();
        $class->isVisible      = $this->getIsVisible();

        return $class;
    }

    public function getAllData()
    {
        $class = $this->getData();

        $class->products = [];
        foreach ($this->getProducts() as $product) {
            $class->products[] = $product->getData();
        }

        return $class;
    }
}
