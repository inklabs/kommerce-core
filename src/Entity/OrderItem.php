<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderItemDTOBuilder;
use inklabs\kommerce\View;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OrderItem implements ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $quantity;

    /** @var Price */
    protected $price;

    /** @var Product */
    protected $product;

    /** @var OrderItemOptionProduct[] */
    protected $orderItemOptionProducts;

    /** @var OrderItemOptionValue[] */
    protected $orderItemOptionValues;

    /** @var OrderItemTextOptionValue[] */
    protected $orderItemTextOptionValues;

    /** @var Order */
    protected $order;

    /** @var CatalogPromotion[] */
    protected $catalogPromotions;

    /** @var ProductQuantityDiscount[] */
    protected $productQuantityDiscounts;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var string */
    protected $discountNames;

    public function __construct()
    {
        $this->setCreated();
        $this->catalogPromotions = new ArrayCollection;
        $this->productQuantityDiscounts = new ArrayCollection;
        $this->orderItemOptionProducts = new ArrayCollection;
        $this->orderItemOptionValues = new ArrayCollection;
        $this->orderItemTextOptionValues = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('sku', new Assert\Length([
            'max' => 64,
        ]));

        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
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

        $this->setName($product->getName());
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getOrderItemOptionProducts()
    {
        return $this->orderItemOptionProducts;
    }

    public function addOrderItemOptionProduct(OrderItemOptionProduct $orderItemOptionProduct)
    {
        $orderItemOptionProduct->setOrderItem($this);
        $this->orderItemOptionProducts[] = $orderItemOptionProduct;
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

    public function getOrderItemTextOptionValues()
    {
        return $this->orderItemTextOptionValues;
    }

    public function addOrderItemTextOptionValue(OrderItemTextOptionValue $orderItemTextOptionValue)
    {
        $orderItemTextOptionValue->setOrderItem($this);
        $this->orderItemTextOptionValues[] = $orderItemTextOptionValue;
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

    public function setSku($sku)
    {
        $this->sku = (string) $sku;
    }

    public function getSku()
    {
        $fullSku = [];

        if ($this->sku !== null) {
            $fullSku[] = $this->sku;
        }

        $product = $this->getProduct();
        if ($product !== null) {
            $sku = $product->getSku();

            if ($sku !== null) {
                $fullSku[] = $product->getSku();
            }
        }

        foreach ($this->getOrderItemOptionProducts() as $orderItemOptionProduct) {
            $sku = $orderItemOptionProduct->getSku();

            if ($sku !== null) {
                $fullSku[] = $sku;
            }
        }

        foreach ($this->getOrderItemOptionValues() as $orderItemOptionValue) {
            $sku = $orderItemOptionValue->getSku();

            if ($sku !== null) {
                $fullSku[] = $sku;
            }
        }

        return implode('-', $fullSku);
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
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

    public function getDTOBuilder()
    {
        return new OrderItemDTOBuilder($this);
    }
}
