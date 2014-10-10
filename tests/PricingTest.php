<?php
use inklabs\kommerce\Pricing;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\ProductQuantityDiscount;

class PricingTest extends PHPUnit_Framework_TestCase
{
	private function setup_product()
	{
		$product = new Product;
		$product->sku = 'TST101';
		$product->name = 'Test Product';
		$product->price = 1500;

		return $product;
	}

	/**
	 * @covers Pricing::get_price
	 */
	public function test_get_price_basic()
	{
		$pricing = new Pricing;

		$product = $this->setup_product();

		// Expected
		$price = new Price;
		$price->orig_unit_price = 1500;
		$price->unit_price = 1500;
		$price->orig_quantity_price = 1500;
		$price->quantity_price = 1500;
		$this->assertEquals($price, $pricing->get_price($product, 1));

		// Expected
		$price = new Price;
		$price->orig_unit_price = 1500;
		$price->unit_price = 1500;
		$price->orig_quantity_price = 3000;
		$price->quantity_price = 3000;
		$this->assertEquals($price, $pricing->get_price($product, 2));

		// Expected
		$price = new Price;
		$price->orig_unit_price = 1500;
		$price->unit_price = 1500;
		$price->orig_quantity_price = 15000;
		$price->quantity_price = 15000;
		$this->assertEquals($price, $pricing->get_price($product, 10));
	}

	/**
	 * @covers Pricing::get_price
	 */
	public function test_get_price_with_catalog_promotion_percent()
	{
		$catalog_promotion = new CatalogPromotion;
		$catalog_promotion->name = '20% Off';
		$catalog_promotion->discount_type = 'percent';
		$catalog_promotion->value = 20;
		$catalog_promotion->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
		$catalog_promotion->end = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

		$pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));
		$pricing->add_catalog_promotion($catalog_promotion);

		$product = $this->setup_product();

		// Expected
		$price = new Price;
		$price->unit_price = 1200;
		$price->orig_unit_price = 1500;
		$price->add_catalog_promotion($catalog_promotion);
		$price->quantity_price = 1200;
		$price->orig_quantity_price = 1500;
		$this->assertEquals($price, $pricing->get_price($product, 1));

		// Expected
		$price = new Price;
		$price->unit_price = 1200;
		$price->orig_unit_price = 1500;
		$price->add_catalog_promotion($catalog_promotion);
		$price->quantity_price = 2400;
		$price->orig_quantity_price = 3000;
		$this->assertEquals($price, $pricing->get_price($product, 2));

		// Expected
		$price = new Price;
		$price->unit_price = 1200;
		$price->orig_unit_price = 1500;
		$price->add_catalog_promotion($catalog_promotion);
		$price->quantity_price = 12000;
		$price->orig_quantity_price = 15000;
		$this->assertEquals($price, $pricing->get_price($product, 10));
	}

	/**
	 * @covers Pricing::get_price
	 */
	public function test_get_price_with_catalog_promotion_fixed()
	{
		$catalog_promotion = new CatalogPromotion;
		$catalog_promotion->name = '$1 Off';
		$catalog_promotion->discount_type = 'fixed';
		$catalog_promotion->value = 100;
		$catalog_promotion->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
		$catalog_promotion->end = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

		$pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));
		$pricing->add_catalog_promotion($catalog_promotion);

		$product = $this->setup_product();

		// Expected
		$price = new Price;
		$price->unit_price = 1400;
		$price->orig_unit_price = 1500;
		$price->add_catalog_promotion($catalog_promotion);
		$price->quantity_price = 1400;
		$price->orig_quantity_price = 1500;
		$this->assertEquals($price, $pricing->get_price($product, 1));

		// Expected
		$price = new Price;
		$price->unit_price = 1400;
		$price->orig_unit_price = 1500;
		$price->add_catalog_promotion($catalog_promotion);
		$price->quantity_price = 2800;
		$price->orig_quantity_price = 3000;
		$this->assertEquals($price, $pricing->get_price($product, 2));

		// Expected
		$price = new Price;
		$price->unit_price = 1400;
		$price->orig_unit_price = 1500;
		$price->add_catalog_promotion($catalog_promotion);
		$price->quantity_price = 14000;
		$price->orig_quantity_price = 15000;
		$this->assertEquals($price, $pricing->get_price($product, 10));
	}

	/**
	 * @covers Pricing::get_price
	 */
	public function test_get_price_with_catalog_promotion_tag()
	{
		$tag = new Tag;
		$tag->id = 1;
		$tag->name = 'Test Tag';

		$catalog_promotion = new CatalogPromotion;
		$catalog_promotion->name = '20% Off';
		$catalog_promotion->discount_type = 'percent';
		$catalog_promotion->value = 20;
		$catalog_promotion->tag = $tag;
		$catalog_promotion->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
		$catalog_promotion->end = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

		$pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));
		$pricing->add_catalog_promotion($catalog_promotion);

		$product = $this->setup_product();

		// Expected
		$price = new Price;
		$price->unit_price = 1500;
		$price->orig_unit_price = 1500;
		$price->quantity_price = 3000;
		$price->orig_quantity_price = 3000;
		$this->assertEquals($price, $pricing->get_price($product, 2));

		// Add tag
		$product->tags[] = $tag;
		$price->unit_price = 1200;
		$price->quantity_price = 2400;
		$price->add_catalog_promotion($catalog_promotion);
		$this->assertEquals($price, $pricing->get_price($product, 2));
	}

	/**
	 * @covers Pricing::get_price
	 */
	public function test_get_price_with_product_options()
	{
		$option = new Option;
		$option->name = 'Size';
		$option->type = 'radio';
		$option->description = 'Navy T-shirt size';

		$product_small = new Product;
		$product_small->sku = 'TS-NAVY-SM';
		$product_small->name = 'Navy T-shirt (small)';
		$product_small->price = 900;

		$option->add_product($product_small);

		$product = $this->setup_product();
		$product->add_option($option);
		$product->add_selected_option_product($product_small);

		$pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));

		// Expected
		$price = new Price;
		$price->unit_price = 2400;
		$price->orig_unit_price = 2400;
		$price->quantity_price = 2400;
		$price->orig_quantity_price = 2400;
		$this->assertEquals($price, $pricing->get_price($product, 1));

		// Expected
		$price = new Price;
		$price->unit_price = 2400;
		$price->orig_unit_price = 2400;
		$price->quantity_price = 4800;
		$price->orig_quantity_price = 4800;
		$this->assertEquals($price, $pricing->get_price($product, 2));

		// Expected
		$price = new Price;
		$price->unit_price = 2400;
		$price->orig_unit_price = 2400;
		$price->quantity_price = 24000;
		$price->orig_quantity_price = 24000;
		$this->assertEquals($price, $pricing->get_price($product, 10));
	}

	/**
	 * @covers Pricing::get_price
	 */
	public function test_get_price_with_product_quantity_discount()
	{
		$quantity_discount_6 = new ProductQuantityDiscount;
		$quantity_discount_6->apply_catalog_promotions = TRUE;
		$quantity_discount_6->discount_type = 'exact';
		$quantity_discount_6->quantity = 6;
		$quantity_discount_6->value = 475;
		$quantity_discount_6->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
		$quantity_discount_6->end = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

		$product = $this->setup_product();
		$product->price = 500;
		$product->add_quantity_discount($quantity_discount_6);

		$pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));

		// Expected
		$price = new Price;
		$price->unit_price = 500;
		$price->orig_unit_price = 500;
		$price->quantity_price = 500;
		$price->orig_quantity_price = 500;
		$this->assertEquals($price, $pricing->get_price($product, 1));

		// Expected
		$price = new Price;
		$price->unit_price = 475;
		$price->orig_unit_price = 500;
		$price->quantity_price = 2850;
		$price->orig_quantity_price = 3000;
		$price->add_quantity_discount($quantity_discount_6);
		$this->assertEquals($price, $pricing->get_price($product, 6));
	}
}
