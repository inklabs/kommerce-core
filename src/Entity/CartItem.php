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

    /* @var Product[] */
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

    public function addOptionProduct(Product $optionProduct)
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
                $optionProduct,
                $this->getQuantity()
            );

            $price = Price::add($price, $optionPrice);
        }

        return $price;
    }

    public function getShippingWeight()
    {
        $shippingWeight = ($this->getProduct()->getShippingWeight() * $this->getQuantity());

        foreach ($this->getOptionProducts() as $optionProduct) {
            $shippingWeight += ($optionProduct->getShippingWeight() * $this->getQuantity());
        }

        return $shippingWeight;
    }

    public function getOrderItem(Pricing $pricing)
    {
        return new OrderItem($this->getProduct(), $this->getQuantity(), $this->getPrice($pricing));
    }

    public function getView()
    {
        return new View\CartItem($this);
    }
}
