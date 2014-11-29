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

    public function __construct(CartItem $cartItem, Pricing $pricing)
    {
        $this->catalogPromotions = new ArrayCollection;
        $this->product = $cartItem->getProduct();
        $this->quantity = $cartItem->getQuantity();
        $this->setPrice($cartItem->getPrice($pricing));
    }

    private function setPrice(Price $price)
    {
        $this->price = $price;

        foreach ($price->getCatalogPromotions() as $catalogPromotion) {
            $this->catalogPromotions[] = $catalogPromotion;
        }

        $this->productQuantityDiscount = $price->getProductQuantityDiscount();
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
