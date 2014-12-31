<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use Doctrine\Common\Collections\ArrayCollection;

class OrderItem
{
    use Accessor\Time;

    protected $id;
    protected $quantity;

    /* @var Price */
    protected $price;

    /* @var Product */
    protected $product;

    /* @var Order */
    protected $order;

    /* @var CatalogPromotion[] */
    protected $catalogPromotions;

    /* @var ProductQuantityDiscount */
    protected $productQuantityDiscount;

    /* Flattened Columns */
    protected $productSku;
    protected $productName;
    protected $discountNames;

    public function __construct(CartItem $cartItem, Pricing $pricing)
    {
        $this->setCreated();
        $this->catalogPromotions = new ArrayCollection;
        $this->quantity = $cartItem->getQuantity();

        $this->setProduct($cartItem->getProduct());
        $this->setPrice($cartItem->getPrice($pricing));
    }

    private function setProduct(Product $product)
    {
        $this->product = $product;

        $this->productSku = $product->getSku();
        $this->productName = $product->getName();
    }

    public function getProduct()
    {
        return $this->product;
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

    private function setPrice(Price $price)
    {
        $this->price = $price;

        $discountNames = [];
        foreach ($price->getCatalogPromotions() as $catalogPromotion) {
            $this->catalogPromotions[] = $catalogPromotion;
            $discountNames[] = $catalogPromotion->getName();
        }

        $this->productQuantityDiscount = $price->getProductQuantityDiscount();

        if ($this->productQuantityDiscount !== null) {
            $discountNames[] = $this->productQuantityDiscount->getName();
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

    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function getProductQuantityDiscount()
    {
        return $this->productQuantityDiscount;
    }

    public function getView()
    {
        return new View\OrderItem($this);
    }
}
