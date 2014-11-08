<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class ProductQuantityDiscount extends Promotion
{
    public $customerGroup;
    public $flagApplyCatalogPromotions;
    public $quantity;
    public $product;
    public $price;

    public function __construct(Entity\ProductQuantityDiscount $productQuantityDiscount)
    {
        parent::__construct($productQuantityDiscount);

        $this->customerGroup              = $productQuantityDiscount->getCustomerGroup();
        $this->quantity                   = $productQuantityDiscount->getQuantity();
        $this->flagApplyCatalogPromotions = $productQuantityDiscount->getFlagApplyCatalogPromotions();
        $this->product                    = $productQuantityDiscount->getProduct();
    }

    public static function factory(Entity\ProductQuantityDiscount $productQuantityDiscount)
    {
        return new static($productQuantityDiscount);
    }

    public function withPrice()
    {
        $this->price = Price::factory($this->promotion->getPrice())
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct()
    {
        if (! empty($this->product)) {
            $this->product = $this->product
                ->getView()
                ->withAllData()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withPrice()
            ->withProduct();
    }
}
