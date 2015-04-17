<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Entity\OptionValue\OptionValueInterface;
use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\View;
use Doctrine\Common\Collections\ArrayCollection;

class CartItem
{
    use Accessor\Created, Accessor\Id;

    /** @var int */
    protected $quantity;

    /** @var Product */
    protected $product;

    /** @var OptionValueInterface[] */
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

    public function addOptionValue(OptionValue\OptionValueInterface $optionValueProduct)
    {
        $this->optionValues[] = $optionValueProduct;
    }

    /**
     * @param OptionValue\OptionValueInterface[] $optionValues
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
        $price = $this->getProduct()->getPrice(
            $pricing,
            $this->getQuantity()
        );

        foreach ($this->getOptionValues() as $optionValue) {
            $optionPrice = $optionValue->getPrice(
                $pricing,
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
        $shippingWeight = $this->getProduct()->getShippingWeight();

        foreach ($this->getOptionValues() as $optionValue) {
            $shippingWeight += $optionValue->getShippingWeight();
        }

        $quantityShippingWeight = $shippingWeight * $this->getQuantity();

        return $quantityShippingWeight;
    }

    public function getOrderItem(Pricing $pricing)
    {
        $orderItem = new OrderItem;
        $orderItem->setProduct($this->getProduct());
        $orderItem->setQuantity($this->getQuantity());
        $orderItem->setPrice($this->getPrice($pricing));

        foreach ($this->getOptionValues() as $optionValue) {
            $orderItem->addOrderItemOptionValue(new OrderItemOptionValue($optionValue));
        }

        return $orderItem;
    }

    public function getView()
    {
        return new View\CartItem($this);
    }
}
