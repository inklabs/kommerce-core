<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class CartItemTextOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $textOption = new TextOption;
        $textOption->setType(TextOption::TYPE_TEXTAREA);
        $textOption->setName('Custom Message');
        $textOption->setDescription('Custom engraved message');

        $cartItemTextOptionValue = new CartItemTextOptionValue;
        $cartItemTextOptionValue->setTextOption($textOption);
        $cartItemTextOptionValue->setTextOptionValue('Happy Birthday');
        $cartItemTextOptionValue->setCartItem(new CartItem);

        $this->assertSame('Happy Birthday', $cartItemTextOptionValue->getTextOptionValue());
        $this->assertTrue($cartItemTextOptionValue->getTextOption() instanceof TextOption);
        $this->assertTrue($cartItemTextOptionValue->getCartItem() instanceof CartItem);
        $this->assertTrue($cartItemTextOptionValue->getView() instanceof View\CartItemTextOptionValue);
    }
}
