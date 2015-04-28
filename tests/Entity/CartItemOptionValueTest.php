<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class CartItemOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setType(Option::TYPE_SELECT);
        $option->setName('Shirt Size');
        $option->setDescription('Shirt Size Description');

        $optionValue = new OptionValue;
        $optionValue->setSortOrder(0);
        $optionValue->setSku('MD');
        $optionValue->setName('Medium Shirt');
        $optionValue->setShippingWeight(6);
        $optionValue->setUnitPrice(500);
        $optionValue->setOption($option);

        $cartItemOptionValue = new CartItemOptionValue;
        $cartItemOptionValue->setOptionValue($optionValue);
        $cartItemOptionValue->setCartItem(new CartItem);

        $this->assertSame('MD', $cartItemOptionValue->getSku());
        $this->assertSame(6, $cartItemOptionValue->getShippingWeight());
        $this->assertTrue($cartItemOptionValue->getPrice() instanceof Price);
        $this->assertTrue($cartItemOptionValue->getOptionValue() instanceof OptionValue);
        $this->assertTrue($cartItemOptionValue->getCartItem() instanceof CartItem);
        $this->assertTrue($cartItemOptionValue->getView() instanceof View\CartItemOptionValue);
    }
}
