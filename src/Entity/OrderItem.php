<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use Doctrine\Common\Collections\ArrayCollection;

class OrderItem
{
    use Accessor\Time;

    protected $id;
    protected $product;
    protected $quantity;
    protected $price;

    protected $order;

    protected $catalogPromotions;
    protected $productQuantityDiscount;

    /* Flattened Columns */
    protected $productSku;
    protected $productName;
    protected $discountNames;

    public function __construct(CartItem $cartItem, Pricing $pricing)
    {
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

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }
}
