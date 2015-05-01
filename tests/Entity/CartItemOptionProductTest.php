<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class CartItemOptionProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setType(Option::TYPE_SELECT);
        $option->setName('Team Logo');
        $option->setDescription('Embroidered Team Logo');

        $logoProduct = new Product;
        $logoProduct->setSku('LAA');
        $logoProduct->setName('LA Angels');
        $logoProduct->setShippingWeight(6);

        $optionProduct = new OptionProduct;
        $optionProduct->setProduct($logoProduct);
        $optionProduct->setSortOrder(0);
        $optionProduct->setOption($option);

        $cartItemOptionProduct = new CartItemOptionProduct;
        $cartItemOptionProduct->setOptionProduct($optionProduct);
        $cartItemOptionProduct->setCartItem(new CartItem);

        $this->assertSame('LAA', $cartItemOptionProduct->getSku());
        $this->assertSame(6, $cartItemOptionProduct->getShippingWeight());
        $this->assertTrue($cartItemOptionProduct->getPrice(new Lib\Pricing) instanceof Price);
        $this->assertTrue($cartItemOptionProduct->getOptionProduct() instanceof OptionProduct);
        $this->assertTrue($cartItemOptionProduct->getCartItem() instanceof CartItem);
        $this->assertTrue($cartItemOptionProduct->getView() instanceof View\CartItemOptionProduct);
    }
}
