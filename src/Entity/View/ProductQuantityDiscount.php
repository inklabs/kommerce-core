<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service\Pricing;

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

    public function withPrice(Pricing $pricing)
    {
        $this->price = $this->promotion->getPrice($pricing)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        $product = $this->promotion->getProduct();
        if ($product !== null) {
            $this->product = $product->getView()
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
