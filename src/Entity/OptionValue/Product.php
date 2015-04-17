<?php
namespace inklabs\kommerce\Entity\OptionValue;

use inklabs\kommerce\Entity\OptionType\OptionTypeInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class Product extends AbstractOptionValue implements OptionValueInterface
{
    /** @var Entity\Product */
    protected $product;

    public function __construct(Entity\Product $product)
    {
        parent::__construct();
        $this->setProduct($product);
    }

    public function getName()
    {
        return $this->getProduct()->getName();
    }

    public function getSku()
    {
        return $this->getProduct()->getSku();
    }

    public function getShippingWeight()
    {
        return $this->getProduct()->getShippingWeight();
    }

    /**
     * @param Service\Pricing $pricing
     * @param int $quantity
     * @return Entity\Price
     */
    public function getPrice(Service\Pricing $pricing, $quantity = 1)
    {
        return $this->getProduct()->getPrice($pricing, $quantity);
    }

    public function setProduct(Entity\Product $product)
    {
        $product->addOptionValue($this);
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getView()
    {
        return new View\OptionValue\Product($this);
    }
}
