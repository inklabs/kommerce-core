<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('description', new Assert\Length([
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('sortOrder', new Assert\NotNull);
        $metadata->addPropertyConstraint('sortOrder', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function loadFromView(View\Tag $viewTag)
    {
        $this->setName($viewTag->name);
        $this->setDescription($viewTag->description);
        $this->setDefaultImage($viewTag->defaultImage);
        $this->setSortOrder($viewTag->sortOrder);
        $this->setIsVisible($viewTag->isVisible);
        $this->setIsActive($viewTag->isActive);
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

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
        $this->isActive = (bool) $isActive;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsVisible($isVisible)
    {
        $this->isVisible = (bool) $isVisible;
    }

    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function getView()
    {
        return new View\Tag($this);
    }
}
