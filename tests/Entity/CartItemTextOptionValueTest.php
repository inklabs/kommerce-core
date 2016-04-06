<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartItemTextOptionValueTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $cartItemTextOptionValue = new CartItemTextOptionValue;

        $this->assertSame(null, $cartItemTextOptionValue->getTextOptionValue());
        $this->assertSame(null, $cartItemTextOptionValue->getTextOption());
        $this->assertSame(null, $cartItemTextOptionValue->getCartItem());
    }

    public function testCreate()
    {
        $textOption = $this->dummyData->getTextOption();
        $cartItem = $this->dummyData->getCartItem();

        $cartItemTextOptionValue = new CartItemTextOptionValue;
        $cartItemTextOptionValue->setTextOptionValue('Happy Birthday');
        $cartItemTextOptionValue->setTextOption($textOption);
        $cartItemTextOptionValue->setCartItem($cartItem);

        $this->assertEntityValid($cartItemTextOptionValue);
        $this->assertSame('Happy Birthday', $cartItemTextOptionValue->getTextOptionValue());
        $this->assertSame($textOption, $cartItemTextOptionValue->getTextOption());
        $this->assertSame($cartItem, $cartItemTextOptionValue->getCartItem());
    }
}
