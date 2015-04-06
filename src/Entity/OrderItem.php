<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OrderItem
{
    use Accessor\Time, Accessor\Id;

    /** @var int */
    protected $quantity;

    /** @var Price */
    protected $price;

    /** @var Product */
    protected $product;

    /** @var OrderItemOptionValue[] */
    protected $orderItemOptionValues;

    /** @var Order */
    protected $order;

    /** @var CatalogPromotion[] */
    protected $catalogPromotions;

    /** @var ProductQuantityDiscount[] */
    protected $productQuantityDiscounts;

    /** Flattened Columns */
    protected $productSku;
    protected $productName;
    protected $discountNames;

    public function __construct()
    {
        $this->setCreated();
        $this->catalogPromotions = new ArrayCollection;
        $this->productQuantityDiscounts = new ArrayCollection;
        $this->orderItemOptionValues = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('productSku', new Assert\Length([
            'max' => 64,
        ]));

        $metadata->addPropertyConstraint('productName', new Assert\NotBlank);
        $metadata->addPropertyConstraint('productName', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('discountNames', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('price', new Assert\Valid);
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;

        $this->productSku = $product->getSku();
        $this->productName = $product->getName();
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getOrderItemOptionValues()
    {
        return $this->orderItemOptionValues;
    }

    public function addOrderItemOptionValue(OrderItemOptionValue $orderItemOptionValue)
    {
        $orderItemOptionValue->setOrderItem($this);
        $this->orderItemOptionValues[] = $orderItemOptionValue;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getProductSku()
    {
        return $this->productSku;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function getFullSku()
    {
        $fullSku = [];
        $fullSku[] = $this->getProduct()->getSku();

        foreach ($this->getOrderItemOptionValues() as $optionValue) {
            $fullSku[] = $optionValue->getSku();
        }

        return implode('-', $fullSku);
    }

    public function setPrice(Price $price)
    {
        $this->price = $price;

        $discountNames = [];
        foreach ($price->getCatalogPromotions() as $catalogPromotion) {
            $this->addCatalogPromotion($catalogPromotion);
            $discountNames[] = $catalogPromotion->getName();
        }

        foreach ($price->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->addProductQuantityDiscount($productQuantityDiscount);
            $discountNames[] = $productQuantityDiscount->getName();
        }

        $this->discountNames = implode(', ', $discountNames);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDiscountNames()
    {
        return $this->discountNames;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
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
        return new View\OrderItem($this);
    }
}
