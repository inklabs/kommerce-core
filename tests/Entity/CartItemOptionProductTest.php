<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartItemOptionProductTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $cartItemOptionProduct = new CartItemOptionProduct;

        $this->assertSame(null, $cartItemOptionProduct->getOptionProduct());
        $this->assertSame(null, $cartItemOptionProduct->getCartItem());
    }

    public function testCreate()
    {
        $pricing = $this->dummyData->getPricing();
        $cartItem = $this->dummyData->getCartItem();

        $optionProduct = $this->dummyData->getOptionProduct();
        $optionProduct->getProduct()->setSku('LAA');
        $optionProduct->getProduct()->setShippingWeight(6);

        $cartItemOptionProduct = new CartItemOptionProduct;
        $cartItemOptionProduct->setOptionProduct($optionProduct);
        $cartItemOptionProduct->setCartItem($cartItem);

        $this->assertSame('LAA', $cartItemOptionProduct->getSku());
        $this->assertSame(6, $cartItemOptionProduct->getShippingWeight());
        $this->assertTrue($cartItemOptionProduct->getPrice($pricing) instanceof Price);
        $this->assertSame($optionProduct, $cartItemOptionProduct->getOptionProduct());
        $this->assertSame($cartItem, $cartItemOptionProduct->getCartItem());
    }
}
