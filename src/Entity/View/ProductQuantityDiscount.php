<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service\Pricing;

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

    public function withPrice(Pricing $pricing)
    {
        $this->price = Price::factory($this->promotion->getPrice($pricing))
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        if (! empty($this->product)) {
            $this->product = Product::factory($this->product)
                ->withAllData($pricing)
                ->export();
        }
        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withPrice($pricing)
            ->withProduct($pricing);
    }
}
