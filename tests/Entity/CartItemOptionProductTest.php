<?php
namespace inklabs\kommerce\Entity;

class CartItemOptionProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCartItemOptionProduct()
    {
        $cartItemOptionProduct = new CartItemOptionProduct(new Option, new Product);
        $cartItemOptionProduct->setId(1);

        $this->assertSame(1, $cartItemOptionProduct->getId());
        $this->assertTrue($cartItemOptionProduct->getOption() instanceof Option);
        $this->assertTrue($cartItemOptionProduct->getProduct() instanceof Product);
        $this->assertTrue($cartItemOptionProduct->getView() instanceof View\CartItemOptionProduct);
    }
}
