<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class CartItemTest extends Helper\DoctrineTestCase
{
    public function testCreate()
    {
        $cartItem = $this->getDummyCartItem();

        $viewCartItem = $cartItem->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($viewCartItem->price instanceof Price);
        $this->assertTrue($viewCartItem->product instanceof Product);
        $this->assertTrue($viewCartItem->cartItemOptionProducts[0] instanceof CartItemOptionProduct);
        $this->assertTrue($viewCartItem->cartItemOptionValues[0] instanceof CartItemOptionValue);
        $this->assertTrue($viewCartItem->cartItemTextOptionValues[0] instanceof CartItemTextOptionValue);
    }
}
