<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class ProductQuantityDiscount extends Promotion
{
    public $customerGroup;
    public $flagApplyCatalogPromotions;
    public $quantity;
    public $product;
    public $priceObj;

    public function __construct(Entity\ProductQuantityDiscount $productQuantityDiscount)
    {
        parent::__construct($productQuantityDiscount);

        $this->customerGroup              = $productQuantityDiscount->getCustomerGroup();
        $this->quantity                   = $productQuantityDiscount->getQuantity();
        $this->flagApplyCatalogPromotions = $productQuantityDiscount->getFlagApplyCatalogPromotions();
        $this->product                    = $productQuantityDiscount->getProduct();
    }

    public function withPriceObj()
    {
        $this->priceObj = $this->promotion->getPriceObj();
        if (! empty($this->priceObj)) {
            $this->priceObj = $this->priceObj
                ->getView()
                ->withAllData()
                ->export();
        }
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
            ->withPriceObj()
            ->withProduct();
    }
}
