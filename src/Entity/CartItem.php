<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use Doctrine\Common\Collections\ArrayCollection;

class CartItem
{
    use Accessor\Created, Accessor\Id;

    /** @var int */
    protected $quantity;

    /** @var Product */
    protected $product;

    /** @var OptionValue[] */
    protected $optionValues;

    public function __construct(Product $product, $quantity)
    {
        $this->setCreated();
        $this->optionValues = new ArrayCollection;

        $this->setProduct($product);
        $this->setQuantity($quantity);
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getOptionValues()
    {
        return $this->optionValues;
    }

    public function addOptionValue(OptionValue $optionValue)
    {
        $this->optionValues[] = $optionValue;
    }

    /**
     * @param OptionValue[] $optionValues
     */
    public function setOptionValues($optionValues)
    {
        $this->optionValues = new ArrayCollection;

        foreach ($optionValues as $optionValue) {
            $this->addOptionValue($optionValue);
        }
    }

    public function getPrice(Pricing $pricing)
    {
        $price = $pricing->getPrice(
            $this->getProduct(),
            $this->getQuantity()
        );

        foreach ($this->getOptionValues() as $optionValue) {
            $optionPrice = $pricing->getPrice(
                $optionValue->getProduct(),
                $this->getQuantity()
            );

            $price = Price::add($price, $optionPrice);
        }

        return $price;
    }

    public function getFullSku()
    {
        $fullSku = [];
        $fullSku[] = $this->getProduct()->getSku();

        foreach ($this->getOptionValues() as $optionValue) {
            $fullSku[] = $optionValue->getSku();
        }

        return implode('-', $fullSku);
    }

    public function getShippingWeight()
    {
        $shippingWeight = ($this->getProduct()->getShippingWeight() * $this->getQuantity());

        foreach ($this->getOptionValues() as $optionValue) {
            $shippingWeight += ($optionValue->getShippingWeight() * $this->getQuantity());
        }

        return $shippingWeight;
    }

    public function getOrderItem(Pricing $pricing)
    {
        $orderItem = new OrderItem($this->getProduct(), $this->getQuantity(), $this->getPrice($pricing));

        foreach ($this->getOptionValues() as $optionValue) {
            $orderItemOptionValue = new OrderItemOptionValue($optionValue);
            $orderItem->addOrderItemOptionValue($orderItemOptionValue);
        }

        return $orderItem;
    }

    public function getView()
    {
        return new View\CartItem($this);
    }
}
