<?php
use inklabs\kommerce\Pricing;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\Product;

class CartTest extends PHPUnit_Framework_TestCase
{
	private function _setup_product()
	{
		$product = new Product;
		$product->sku = 'TST101';
		$product->name = 'Test Product';

		return $product;
	}

	/**
	 * @covers Cart::add_item
	 * @covers Cart::total_items
	 * @covers Cart::total_quantity
	 */
	public function test_add_item()
	{
		$product = $this->_setup_product();
		$product->name = 'Test 1';

		$product2 = $this->_setup_product();
		$product2->name = 'Test 2';

		$cart = new Cart;
		$cart->add_item($product, 5);
		$cart->add_item($product2, 5);

		$this->assertEquals(2, $cart->total_items());
		$this->assertEquals(10, $cart->total_quantity());
	}

	/**
	 * @covers Cart::get_total
	 */
	public function test_get_total()
	{
		$product = $this->_setup_product();
		$product->name = 'Test 1';
		$product->price = 500;

		$product2 = $this->_setup_product();
		$product2->name = 'Test 2';
		$product2->price = 300;

		$cart = new Cart;
		$cart->add_item($product, 2);
		$cart->add_item($product2, 1);

		$cart_total = new CartTotal;
		$cart_total->orig_subtotal = 1300;
		$cart_total->subtotal = 1300;
		$cart_total->shipping = 0;
		$cart_total->discount = 0;
		$cart_total->tax = 0;
		$cart_total->total = 1300;
		$cart_total->savings = 0;

		$pricing = new Pricing;

		$this->assertEquals($cart_total, $cart->get_total($pricing));
	}
}
