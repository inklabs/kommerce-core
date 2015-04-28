<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class CartItemTextOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $orderItemTextOptionValue = new Entity\CartItemTextOptionValue('Happy Birthday');
        $orderItemTextOptionValue->setTextOption(new Entity\TextOption);
        $orderItemTextOptionValue->setCartItem(new Entity\CartItem);

        $viewCartItemTextOptionValue = $orderItemTextOptionValue->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($viewCartItemTextOptionValue instanceof CartItemTextOptionValue);
        $this->assertTrue($viewCartItemTextOptionValue->textOption instanceof TextOption);
    }
}
