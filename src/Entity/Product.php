<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 * @Table(name="product")
 **/
class Product
{
    use Accessor\Time;
    use OptionSelector;

    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $sku;

    /** @Column(type="string") **/
    protected $name;

    /** @Column(type="integer") **/
    protected $price;

    /** @Column(type="integer") **/
    protected $quantity;

    /**
     * @OneToOne(targetEntity="Product")
     * @JoinColumn(name="product_group_id")
     **/
    protected $product_group;

    /** @Column(type="boolean", name="require_inventory") **/
    protected $isInventoryRequired;

    /** @Column(type="boolean", name="show_price") **/
    protected $isPriceVisible;

    /** @Column(type="boolean", name="active") **/
    protected $isActive;

    /** @Column(type="boolean", name="visible") **/
    protected $isVisible;

    /** @Column(type="boolean", name="taxable") **/
    protected $isTaxable;

    /** @Column(type="boolean", name="shipping") **/
    protected $isShippable;

    /** @Column(type="integer", name="shipping_weight") **/
    protected $shippingWeight;

    /** @Column(type="string") **/
    protected $description;

    /** @Column(type="integer") **/
    protected $rating;

    /** @Column(type="string", name="default_image") **/
    protected $defaultImage;

    /**
     * @ManyToMany(targetEntity="Tag", fetch="EAGER")
     * @JoinTable(name="product_tag")
    **/
    protected $tags;

    private $quantityDiscounts;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->quantityDiscounts = new ArrayCollection();
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
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setIsInventoryRequired($isInventoryRequired)
    {
        $this->isInventoryRequired = $isInventoryRequired;
    }

    public function getIsInventoryRequired()
    {
        return $this->isInventoryRequired;
    }

    public function setIsPriceVisible($isPriceVisible)
    {
        $this->isPriceVisible = $isPriceVisible;
    }

    public function getIsPriceVisible()
    {
        return $this->isPriceVisible;
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

    public function setIsShippable($isShippable)
    {
        $this->isShippable = $isShippable;
    }

    public function getIsShippable()
    {
        return $this->isShippable;
    }

    public function setShippingWeight($shippingWeight)
    {
        $this->shippingWeight = $shippingWeight;
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
        $this->defaultImage = $defaultImage;
    }

    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    public function setIsTaxable($isTaxable)
    {
        $this->isTaxable = $isTaxable;
    }

    public function getIsTaxable()
    {
        return $this->isTaxable;
    }

    public function setRating($rating)
    {
        return $this->rating = $rating;
    }

    public function getRating()
    {
        return ($this->rating / 100);
    }

    public function inStock()
    {
        if (($this->isInventoryRequired and $this->quantity > 0) or ( ! $this->isInventoryRequired)) {
            return true;
        } else {
            return false;
        }
    }

    public function addTag($tag)
    {
        $this->tags[$tag->getId()] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addQuantityDiscount(ProductQuantityDiscount $quantityDiscount)
    {
        $this->quantityDiscounts[$quantityDiscount->getId()] = $quantityDiscount;
    }

    public function getQuantityDiscounts()
    {
        return $this->quantityDiscounts;
    }
}
