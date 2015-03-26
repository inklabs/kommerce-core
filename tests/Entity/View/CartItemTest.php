<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityOptionValue = new Entity\OptionValue;
        $entityOptionValue->setProduct(new Entity\Product);

        $entityCartItem = new Entity\CartItem(new Entity\Product, 1);
        $entityCartItem->addOptionValue($entityOptionValue);

        $cartItem = $entityCartItem->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($cartItem->price instanceof Price);
        $this->assertTrue($cartItem->product instanceof Product);
        $this->assertTrue($cartItem->optionValues[0] instanceof OptionValue);
    }
}
