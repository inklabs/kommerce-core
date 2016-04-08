<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\TextOption;

class CartItemTextOptionValueDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cartItemTextOptionValue = new CartItemTextOptionValue('Happy Birthday');
        $cartItemTextOptionValue->setTextOption(new TextOption);
        $cartItemTextOptionValue->setCartItem(new CartItem);

        $cartItemTextOptionValueDTO = $cartItemTextOptionValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartItemTextOptionValueDTO instanceof CartItemTextOptionValueDTO);
        $this->assertTrue($cartItemTextOptionValueDTO->textOption instanceof TextOptionDTO);
    }
}
