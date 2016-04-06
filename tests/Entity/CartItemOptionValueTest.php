<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartItemOptionValueTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $cartItemOptionValue = new CartItemOptionValue;

        $this->assertSame(null, $cartItemOptionValue->getOptionValue());
        $this->assertSame(null, $cartItemOptionValue->getCartItem());
    }

    public function testCreate()
    {
        $cartItem = $this->dummyData->getCartItem();
        $optionValue = $this->dummyData->getOptionValue();
        $optionValue->setSku('MD');
        $optionValue->setShippingWeight(6);

        $cartItemOptionValue = new CartItemOptionValue;
        $cartItemOptionValue->setOptionValue($optionValue);
        $cartItemOptionValue->setCartItem($cartItem);

        $this->assertSame('MD', $cartItemOptionValue->getSku());
        $this->assertSame(6, $cartItemOptionValue->getShippingWeight());
        $this->assertTrue($cartItemOptionValue->getPrice() instanceof Price);
        $this->assertSame($optionValue, $cartItemOptionValue->getOptionValue());
        $this->assertSame($cartItem, $cartItemOptionValue->getCartItem());
    }
}
