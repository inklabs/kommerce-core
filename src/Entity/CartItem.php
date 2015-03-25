<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use Doctrine\Common\Collections\ArrayCollection;

class CartItem
{
    use Accessor\Created;

    protected $id;
    protected $quantity;

    /* @var Product */
    protected $product;

    /* @var CartItemOptionProduct[] */
    protected $optionProducts;

    public function __construct(Product $product, $quantity)
    {
        $this->setCreated();
        $this->optionProducts = new ArrayCollection();

        $this->setProduct($product);
        $this->setQuantity($quantity);
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
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

    public function getOptionProducts()
    {
        return $this->optionProducts;
    }

    public function addOptionProduct(CartItemOptionProduct $optionProduct)
    {
        $this->optionProducts[] = $optionProduct;
    }

    public function getPrice(Pricing $pricing)
    {
        $price = $pricing->getPrice(
            $this->getProduct(),
            $this->getQuantity()
        );

        foreach ($this->getOptionProducts() as $optionProduct) {
            $optionPrice = $pricing->getPrice(
                $optionProduct->getProduct(),
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

        foreach ($this->getOptionProducts() as $optionProduct) {
            $fullSku[] = $optionProduct->getProduct()->getSku();
        }

        return implode('-', $fullSku);
    }

    public function getShippingWeight()
    {
        $shippingWeight = ($this->getProduct()->getShippingWeight() * $this->getQuantity());

        foreach ($this->getOptionProducts() as $optionProduct) {
            $shippingWeight += ($optionProduct->getProduct()->getShippingWeight() * $this->getQuantity());
        }

        return $shippingWeight;
    }

    public function getOrderItem(Pricing $pricing)
    {
        $orderItem = new OrderItem($this->getProduct(), $this->getQuantity(), $this->getPrice($pricing));

        foreach ($this->getOptionProducts() as $optionProduct) {
            $orderItemOptionProduct = new OrderItemOptionProduct(
                $optionProduct->getOption(),
                $optionProduct->getProduct()
            );
            $orderItem->addOptionProduct($orderItemOptionProduct);
        }

        return $orderItem;
    }

    public function getView()
    {
        return new View\CartItem($this);
    }
}
