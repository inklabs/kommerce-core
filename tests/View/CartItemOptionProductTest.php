<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class CartItemOptionProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionProduct = new Entity\OptionProduct;
        $optionProduct->setOption(new Entity\Option);
        $optionProduct->setProduct(new Entity\Product);

        $orderItemOptionProduct = new Entity\CartItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($optionProduct);
        $orderItemOptionProduct->setCartItem(new Entity\CartItem);

        $viewCartItemOptionProduct = $orderItemOptionProduct->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($viewCartItemOptionProduct instanceof CartItemOptionProduct);
    }
}
