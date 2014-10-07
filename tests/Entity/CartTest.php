<?php
use inklabs\kommerce\Pricing;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\CatalogPromotion;
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
	public function test_get_total_basic()
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

	/**
	 * @covers Cart::add_coupon
	 * @covers Cart::get_total
	 */
	public function test_get_total_coupon()
	{
		$product = $this->_setup_product();
		$product->name = 'Test 1';
		$product->price = 500;

		$coupon = new Coupon;
		$coupon->name = '20% Off';
		$coupon->discount_type = 'percent';
		$coupon->discount_value = 20;
		$coupon->start = new \DateTime('2014-01-01');
		$coupon->end = new \DateTime('2014-12-31');

		$cart = new Cart;
		$cart->add_coupon($coupon);
		$cart->add_item($product, 5);

		$cart_total = new CartTotal;
		$cart_total->orig_subtotal = 2500;
		$cart_total->subtotal = 2500;
		$cart_total->shipping = 0;
		$cart_total->discount = 500;
		$cart_total->tax = 0;
		$cart_total->total = 2000;
		$cart_total->savings = 500;
		$cart_total->coupons = [$coupon];

		$pricing = new Pricing(new \DateTime('2014-02-01'));

		$this->assertEquals($cart_total, $cart->get_total($pricing));
	}

	/**
	 * @covers Cart::get_total
	 */
	public function test_get_total_coupon_with_catalog_promotion()
	{
		$product = $this->_setup_product();
		$product->name = 'Test 1';
		$product->price = 500;

		$coupon = new Coupon;
		$coupon->name = '20% Off';
		$coupon->discount_type = 'percent';
		$coupon->discount_value = 20;
		$coupon->start = new \DateTime('2014-01-01');
		$coupon->end = new \DateTime('2014-12-31');

		$cart = new Cart;
		$cart->add_coupon($coupon);
		$cart->add_item($product, 5);

		$cart_total = new CartTotal;
		$cart_total->orig_subtotal = 2500;
		$cart_total->subtotal = 2000;
		$cart_total->shipping = 0;
		$cart_total->discount = 400;
		$cart_total->tax = 0;
		$cart_total->total = 1600;
		$cart_total->savings = 900;
		$cart_total->coupons = [$coupon];

		$catalog_promotion = new CatalogPromotion;
		$catalog_promotion->name = '20% Off';
		$catalog_promotion->discount_type = 'percent';
		$catalog_promotion->discount_value = 20;
		$catalog_promotion->start = new \DateTime('2014-01-01');
		$catalog_promotion->end = new \DateTime('2014-12-31');

		$pricing = new Pricing(new \DateTime('2014-02-01'));
		$pricing->add_catalog_promotion($catalog_promotion);

		$this->assertEquals($cart_total, $cart->get_total($pricing));
	}
}
