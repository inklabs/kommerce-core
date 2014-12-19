<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class OrderItem
{
    public $id;
    public $quantity;
    public $price;
    public $product;
    public $productSku;
    public $productName;
    public $discountNames;
    public $catalogPromotions;
    public $productQuantityDiscount;

    public function __construct(Entity\OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;

        $this->id            = $orderItem->getId();
        $this->quantity      = $orderItem->getQuantity();
        $this->price         = $orderItem->getPrice();
        $this->product       = $orderItem->getProduct()->getView()->export();
        $this->productSku    = $orderItem->getProductSku();
        $this->productName   = $orderItem->getProductName();
        $this->discountNames = $orderItem->getDiscountNames();

        $this->productQuantityDiscount = $orderItem->getProductQuantityDiscount();

        return $this;
    }

    public static function factory(Entity\OrderItem $orderItem)
    {
        return new static($orderItem);
    }

    public function export()
    {
        unset($this->orderItem);
        return $this;
    }

    public function withCatalogPromotions()
    {
        foreach ($this->orderItem->getCatalogPromotions() as $catalogPromotion) {
            $this->catalogPromotions[] = $catalogPromotion->getView()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withCatalogPromotions()
            ->export();
    }
}
