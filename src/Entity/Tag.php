<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Tag
{
    use Accessor\Time;

    protected $id;
    protected $name;
    protected $description;
    protected $defaultImage;
    protected $sortOrder;
    protected $isActive;
    protected $isVisible;

    /* @var Product[] */
    protected $products;

    /* @var Image[] */
    protected $images;

    public function __construct()
    {
        $this->setCreated();
        $this->products = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->sortOrder = 0;
        $this->isActive = false;
        $this->isVisible = false;
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    }

    public function getIsVisible()
    {
        return $this->isVisible;
    }
}
