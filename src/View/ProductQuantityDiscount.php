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

    public function withPrice(Lib\PricingInterface $pricing)
    {
        $this->price = $this->promotion->getPrice($pricing)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(Lib\PricingInterface $pricing)
    {
        $product = $this->promotion->getProduct();
        if ($product !== null) {
            $this->product = $product->getView()
                ->withAllData($pricing)
                ->export();
        }
        return $this;
    }

    public function withAllData(Lib\PricingInterface $pricing)
    {
        return $this
            ->withPrice($pricing)
            ->withProduct($pricing);
    }
}
