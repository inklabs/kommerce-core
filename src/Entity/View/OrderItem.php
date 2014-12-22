<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class OrderItem
{
    public $id;
    public $quantity;
    public $price;

    /* @var Product */
    public $product;
    public $productSku;
    public $productName;
    public $discountNames;

    /* @var CatalogPromotion[] */
    public $catalogPromotions;

    /* @var ProductQuantityDiscount */
    public $productQuantityDiscount;

    public function __construct(Entity\OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;

        $this->id            = $orderItem->getId();
        $this->quantity      = $orderItem->getQuantity();
        $this->productSku    = $orderItem->getProductSku();
        $this->productName   = $orderItem->getProductName();
        $this->discountNames = $orderItem->getDiscountNames();

        $this->price = $orderItem->getPrice()->getView()
            ->withAllData()
            ->export();

        $this->product = $orderItem->getProduct()->getView()
            ->withTags()
            ->export();
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

    public function withProductQuantityDiscount()
    {
        $productQuantityDiscount = $this->orderItem->getProductQuantityDiscount();
        if ($productQuantityDiscount !== null) {
            $this->productQuantityDiscount = $productQuantityDiscount->getView()->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withCatalogPromotions()
            ->withProductQuantityDiscount();
    }
}
