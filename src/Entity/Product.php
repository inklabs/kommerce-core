<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Exception\InsufficientInventoryException;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Product implements IdEntityInterface, EnabledAttachmentInterface
{
    use TimeTrait, IdTrait, StringSetterTrait;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var int */
    protected $unitPrice;

    /** @var int */
    protected $quantity;

    /** @var boolean */
    protected $isInventoryRequired;

    /** @var boolean */
    protected $isPriceVisible;

    /** @var boolean */
    protected $isActive;

    /** @var boolean */
    protected $isVisible;

    /** @var boolean */
    protected $isTaxable;

    /** @var boolean */
    protected $isShippable;

    /** @var boolean */
    protected $areAttachmentsEnabled;

    /** @var int (in ounces) */
    protected $shippingWeight;

    /** @var string */
    protected $description;

    /** @var float */
    protected $rating;

    /** @var string */
    protected $defaultImage;

    /** @var Tag[] */
    protected $tags;

    /** @var Image[] */
    protected $images;

    /** @var ProductQuantityDiscount[] */
    protected $productQuantityDiscounts;

    /** @var OptionProduct[] */
    protected $optionProducts;

    /** @var ProductAttribute[] */
    protected $productAttributes;

    public function __construct(UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->tags = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->productQuantityDiscounts = new ArrayCollection();
        $this->optionProducts = new ArrayCollection();
        $this->productAttributes = new ArrayCollection();

        $this->isInventoryRequired = false;
        $this->isPriceVisible = false;
        $this->isActive = false;
        $this->isVisible = false;
        $this->isTaxable = false;
        $this->isShippable = false;

        $this->disableAttachments();

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

    public function getPrice(PricingInterface $pricing, $quantity = 1)
    {
        return $pricing->getPrice(
            $this,
            $quantity
        );
    }

    public function setSku($sku)
    {
        $this->setStringOrNull($this->sku, $sku);
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

    /**
     * @param boolean $isInventoryRequired
     */
    public function setIsInventoryRequired($isInventoryRequired)
    {
        $this->isInventoryRequired = (bool) $isInventoryRequired;
    }

    public function isInventoryRequired()
    {
        return $this->isInventoryRequired;
    }

    /**
     * @param boolean $isPriceVisible
     */
    public function setIsPriceVisible($isPriceVisible)
    {
        $this->isPriceVisible = (bool) $isPriceVisible;
    }

    public function isPriceVisible()
    {
        return $this->isPriceVisible;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = (bool) $isActive;
    }

    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isVisible
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = (bool) $isVisible;
    }

    public function isVisible()
    {
        return $this->isVisible;
    }

    /**
     * @param boolean $isShippable
     */
    public function setIsShippable($isShippable)
    {
        $this->isShippable = (bool) $isShippable;
    }

    public function isShippable()
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
        $this->setStringOrNull($this->description, $description);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDefaultImage($defaultImage)
    {
        $this->setStringOrNull($this->defaultImage, $defaultImage);
    }

    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    public function setIsTaxable($isTaxable)
    {
        $this->isTaxable = (bool) $isTaxable;
    }

    public function isTaxable()
    {
        return $this->isTaxable;
    }

    /**
     * @param float $rating
     */
    public function setRating($rating)
    {
        $this->rating = (float) $rating;
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
        $this->tags->add($tag);
    }

    public function removeTag(Tag $tag)
    {
        return $this->tags->removeElement($tag);
    }

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addImage(Image $image)
    {
        if ($this->images->isEmpty()) {
            $this->setDefaultImage($image->getPath());
        }

        $image->setProduct($this);
        $this->images->add($image);
    }

    public function removeImage(Image $image)
    {
        $result = $this->images->removeElement($image);

        if ($this->getDefaultImage() === $image->getPath()) {
            if (! $this->images->isEmpty()) {
                $this->setDefaultImage($this->images->first()->getPath());
            } else {
                $this->setDefaultImage(null);
            }
        }

        return $result;
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
    }

    public function addProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscounts->add($productQuantityDiscount);
    }

    public function removeProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        return $this->productQuantityDiscounts->removeElement($productQuantityDiscount);
    }

    /**
     * @return ProductQuantityDiscount[]
     */
    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }

    /**
     * @return OptionProduct[]
     */
    public function getOptionProducts()
    {
        return $this->optionProducts;
    }

    public function addOptionProduct(OptionProduct $optionProduct)
    {
        $this->optionProducts->add($optionProduct);
    }

    /**
     * @return ProductAttribute[]
     */
    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    public function addProductAttribute(ProductAttribute $productAttribute)
    {
        $this->productAttributes->add($productAttribute);
    }

    /**
     * @param bool $areAttachmentsEnabled
     */
    public function setAreAttachmentsEnabled($areAttachmentsEnabled)
    {
        $this->areAttachmentsEnabled = (bool) $areAttachmentsEnabled;
    }

    public function disableAttachments()
    {
        $this->areAttachmentsEnabled = false;
    }

    public function enableAttachments()
    {
        $this->areAttachmentsEnabled = true;
    }

    public function areAttachmentsEnabled()
    {
        foreach ($this->tags as $tag) {
            if ($tag->areAttachmentsEnabled()) {
                return true;
            }
        }

        return $this->areAttachmentsEnabled;
    }

    /**
     * @param int $quantity
     * @throws InsufficientInventoryException
     */
    public function reduceQuantity($quantity)
    {
        if ($quantity > $this->quantity) {
            throw new InsufficientInventoryException();
        }

        $this->quantity -= $quantity;
    }
}
