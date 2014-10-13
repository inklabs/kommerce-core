<?php
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;

class CartItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers CartItem::__construct
     */
    public function test_construct()
    {
        $product = new Product;
        $product->name = 'Test Product';

        $cart_item = new CartItem($product, 1);
        $cart_item->id = 1;
        $cart_item->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->assertEquals('1', $cart_item->id);
    }
}
