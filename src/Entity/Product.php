<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Service\Pricing;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Product
{
    use Accessor\Time;
    use OptionSelector;

    protected $id;
    protected $sku;
    protected $name;
    protected $unitPrice;
    protected $quantity;
    protected $isInventoryRequired;
    protected $isPriceVisible;
    protected $isActive;
    protected $isVisible;
    protected $isTaxable;
    protected $isShippable;
    protected $shippingWeight;
    protected $description;
    protected $rating;
    protected $defaultImage;

    /* @var Tag[] */
    protected $tags;

    /* @var Image[] */
    protected $images;

    /* @var ProductQuantityDiscount */
    protected $productQuantityDiscounts;

    public function __construct()
    {
        $this->setCreated();
        $this->tags = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->productQuantityDiscounts = new ArrayCollection();

        $this->isInventoryRequired = false;
        $this->isPriceVisible = false;
        $this->isActive = false;
        $this->isVisible = false;
        $this->isTaxable = false;
        $this->isShippable = false;

        $this->unitPrice = 0;
        $this->quantity = 0;
        $this->shippingWeight = 0;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('sku', new Assert\Length([
            'max' => 64,
        ]));

        $metadata->addPropertyConstraint('description', new Assert\Length([
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('unitPrice', new Assert\NotNull);
        $metadata->addPropertyConstraint('unitPrice', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('shippingWeight', new Assert\NotNull);
        $metadata->addPropertyConstraint('shippingWeight', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function loadFromView(View\Product $viewProduct)
    {
        $this->setName($viewProduct->name);
        $this->setDefaultImage($viewProduct->defaultImage);
        $this->setUnitPrice($viewProduct->unitPrice);
        $this->setQuantity($viewProduct->quantity);
        $this->setIsInventoryRequired($viewProduct->isInventoryRequired);
        $this->setIsPriceVisible($viewProduct->isPriceVisible);
        $this->setIsActive($viewProduct->isActive);
        $this->setIsVisible($viewProduct->isVisible);
        $this->setIsTaxable($viewProduct->isTaxable);
        $this->setIsShippable($viewProduct->isShippable);
        $this->setSku($viewProduct->sku);
        $this->setShippingWeight($viewProduct->shippingWeight);
        $this->setDescription($viewProduct->description);
    }

    public function getPrice(Pricing $pricing, $quantity = 1)
    {
        return $pricing->getPrice(
            $this,
            $quantity
        );
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

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
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = (int) $unitPrice;
    }

    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setIsInventoryRequired($isInventoryRequired)
    {
        $this->isInventoryRequired = (bool) $isInventoryRequired;
    }

    public function getIsInventoryRequired()
    {
        return $this->isInventoryRequired;
    }

    public function setIsPriceVisible($isPriceVisible)
    {
        $this->isPriceVisible = (bool) $isPriceVisible;
    }

    public function getIsPriceVisible()
    {
        return $this->isPriceVisible;
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

    public function setIsShippable($isShippable)
    {
        $this->isShippable = (bool) $isShippable;
    }

    public function getIsShippable()
    {
        return $this->isShippable;
    }

    public function setShippingWeight($shippingWeight)
    {
        $this->shippingWeight = (int) $shippingWeight;
    }

    public function getShippingWeight()
    {
        return $this->shippingWeight;
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
        $this->defaultImage = (string) $defaultImage;
    }

    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    public function setIsTaxable($isTaxable)
    {
        $this->isTaxable = (bool) $isTaxable;
    }

    public function getIsTaxable()
    {
        return $this->isTaxable;
    }

    public function setRating($rating)
    {
        return $this->rating = (float) $rating;
    }

    public function getRating()
    {
        if ($this->rating === null) {
            return null;
        }

        return ($this->rating / 100);
    }

    public function inStock()
    {
        if ($this->isInventoryRequired && ($this->quantity < 1)) {
            return false;
        } else {
            return true;
        }
    }

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscounts[] = $productQuantityDiscount;
    }

    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }

    public function getView()
    {
        return new View\Product($this);
    }
}
