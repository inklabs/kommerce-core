<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $product = new Product;
        $product->setName('Test Product');

        $cart_item = new CartItem($product, 1);
        $cart_item->id = 1;
        $cart_item->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->assertEquals('1', $cart_item->id);
    }
}
