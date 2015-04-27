<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityOptionValue = new Entity\OptionProduct(new Entity\Product);
        $entityOptionValue->setProduct(new Entity\Product);

        $entityCartItem = new Entity\CartItem(new Entity\Product, 1);
        $entityCartItem->addOptionValue($entityOptionValue);

        $cartItem = $entityCartItem->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($cartItem->price instanceof Price);
        $this->assertTrue($cartItem->product instanceof Product);
        $this->assertTrue($cartItem->optionValues[0] instanceof OptionValue\OptionValueInterface);
    }
}
