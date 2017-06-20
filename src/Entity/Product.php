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

    /** @var string|null */
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

    /** @var string|null */
    protected $description;

    /** @var float|null */
    protected $rating;

    /** @var string|null */
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

    public function getPrice(PricingInterface $pricing, $quantity = 1): Price
    {
        return $pricing->getPrice(
            $this,
            $quantity
        );
    }

    public function setSku(?string $sku)
    {
        $this->setStringOrNull($this->sku, $sku);
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setUnitPrice(int $unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setIsInventoryRequired(bool $isInventoryRequired)
    {
        $this->isInventoryRequired = $isInventoryRequired;
    }

    public function isInventoryRequired(): bool
    {
        return $this->isInventoryRequired;
    }

    public function setIsPriceVisible(bool $isPriceVisible)
    {
        $this->isPriceVisible = $isPriceVisible;
    }

    public function isPriceVisible(): bool
    {
        return $this->isPriceVisible;
    }

    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsVisible(bool $isVisible)
    {
        $this->isVisible = $isVisible;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function setIsShippable(bool $isShippable)
    {
        $this->isShippable = $isShippable;
    }

    public function isShippable(): bool
    {
        return $this->isShippable;
    }

    public function setShippingWeight(int $shippingWeight)
    {
        $this->shippingWeight = $shippingWeight;
    }

    public function getShippingWeight(): int
    {
        return $this->shippingWeight;
    }

    public function setDescription(?string $description)
    {
        $this->setStringOrNull($this->description, $description);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDefaultImage(?string $defaultImage)
    {
        $this->setStringOrNull($this->defaultImage, $defaultImage);
    }

    public function getDefaultImage(): ?string
    {
        return $this->defaultImage;
    }

    public function setIsTaxable(bool $isTaxable)
    {
        $this->isTaxable = $isTaxable;
    }

    public function isTaxable(): bool
    {
        return $this->isTaxable;
    }

    public function setRating(?float $rating)
    {
        $this->rating = $rating;
    }

    public function getRating(): ?float
    {
        if ($this->rating === null) {
            return null;
        }

        return ($this->rating / 100);
    }

    public function inStock(): bool
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

    public function setAreAttachmentsEnabled(bool $areAttachmentsEnabled)
    {
        $this->areAttachmentsEnabled = $areAttachmentsEnabled;
    }

    public function disableAttachments()
    {
        $this->areAttachmentsEnabled = false;
    }

    public function enableAttachments()
    {
        $this->areAttachmentsEnabled = true;
    }

    public function areAttachmentsEnabled(): bool
    {
        foreach ($this->tags as $tag) {
            if ($tag->areAttachmentsEnabled()) {
                return true;
            }
        }

        return $this->areAttachmentsEnabled;
    }

    public function reduceQuantity(int $quantity)
    {
        if ($quantity > $this->quantity) {
            throw new InsufficientInventoryException();
        }

        $this->quantity -= $quantity;
    }
}
