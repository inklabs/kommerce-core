<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CartItemTextOptionValueTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $textOptionValue = 'Happy Birthday';
        $cartItemTextOptionValue = new CartItemTextOptionValue($textOptionValue);

        $this->assertSame($textOptionValue, $cartItemTextOptionValue->getTextOptionValue());
        $this->assertSame(null, $cartItemTextOptionValue->getTextOption());
        $this->assertSame(null, $cartItemTextOptionValue->getCartItem());
    }

    public function testCreate()
    {
        $textOption = $this->dummyData->getTextOption();
        $cartItem = $this->dummyData->getCartItem();

        $textOptionValue = 'Happy Birthday';
        $cartItemTextOptionValue = new CartItemTextOptionValue($textOptionValue);
        $cartItemTextOptionValue->setTextOption($textOption);
        $cartItemTextOptionValue->setCartItem($cartItem);

        $this->assertEntityValid($cartItemTextOptionValue);
        $this->assertSame($textOptionValue, $cartItemTextOptionValue->getTextOptionValue());
        $this->assertSame($textOption, $cartItemTextOptionValue->getTextOption());
        $this->assertSame($cartItem, $cartItemTextOptionValue->getCartItem());
    }
}
