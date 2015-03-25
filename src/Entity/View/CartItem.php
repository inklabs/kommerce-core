<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

class CartItem
{
    public $id;
    public $fullSku;
    public $quantity;
    public $shippingWeight;
    public $created;

    /* @var Product */
    public $product;

    /* @var Product[] */
    public $optionProducts = [];

    /* @var Price */
    public $price;

    public function __construct(Entity\CartItem $cartItem)
    {
        $this->cartItem = $cartItem;

        $this->id             = $cartItem->getId();
        $this->fullSku        = $cartItem->getFullSku();
        $this->quantity       = $cartItem->getQuantity();
        $this->shippingWeight = $cartItem->getShippingWeight();
        $this->created        = $cartItem->getCreated();
    }

    public function export()
    {
        unset($this->cartItem);
        return $this;
    }

    public function withPrice(Pricing $pricing)
    {
        $this->price = $this->cartItem->getPrice($pricing)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        $this->product = $this->cartItem->getProduct()->getView()
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->export();

        return $this;
    }

    public function withOptionProducts(Pricing $pricing)
    {
        foreach ($this->cartItem->getOptionProducts() as $optionProduct) {
            $this->optionProducts[] = $optionProduct->getView()
                ->withAllData($pricing)
                ->export();
        }

        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withProduct($pricing)
            ->withPrice($pricing)
            ->withOptionProducts($pricing);
    }
}
