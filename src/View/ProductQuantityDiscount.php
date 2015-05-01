<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class ProductQuantityDiscount extends Promotion
{
    public $customerGroup;
    public $flagApplyCatalogPromotions;
    public $quantity;

    /** @var Product */
    public $product;

    /** @var Price */
    public $price;

    public function __construct(Entity\ProductQuantityDiscount $productQuantityDiscount)
    {
        parent::__construct($productQuantityDiscount);

        $this->customerGroup              = $productQuantityDiscount->getCustomerGroup();
        $this->quantity                   = $productQuantityDiscount->getQuantity();
        $this->flagApplyCatalogPromotions = $productQuantityDiscount->getFlagApplyCatalogPromotions();
    }

    public function withPrice(Lib\Pricing $pricing)
    {
        $this->price = $this->promotion->getPrice($pricing)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(Lib\Pricing $pricing)
    {
        $product = $this->promotion->getProduct();
        if ($product !== null) {
            $this->product = $product->getView()
                ->withAllData($pricing)
                ->export();
        }
        return $this;
    }

    public function withAllData(Lib\Pricing $pricing)
    {
        return $this
            ->withPrice($pricing)
            ->withProduct($pricing);
    }
}
