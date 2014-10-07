<?php
use inklabs\kommerce\Pricing;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\CatalogPromotion;

class PricingTest extends PHPUnit_Framework_TestCase
{
	private function _setup_product()
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

		$product = $this->_setup_product();

		$price = new Price;
		$price->orig_unit_price = 1500;
		$price->unit_price = 1500;

		$price->orig_quantity_price = 1500;
		$price->quantity_price = 1500;
		$this->assertEquals($price, $pricing->get_price($product, 1));

		$price->orig_quantity_price = 3000;
		$price->quantity_price = 3000;
		$this->assertEquals($price, $pricing->get_price($product, 2));

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
		$catalog_promotion->discount_value = 20;
		$catalog_promotion->start = new \DateTime('2014-01-01');
		$catalog_promotion->end = new \DateTime('2014-12-31');

		$pricing = new Pricing(new \DateTime('2014-02-01'));
		$pricing->add_catalog_promotion($catalog_promotion);

		$product = $this->_setup_product();

		$price = new Price;
		$price->unit_price = 1200;
		$price->orig_unit_price = 1500;
		$price->catalog_promotions = [$catalog_promotion];

		$price->quantity_price = 1200;
		$price->orig_quantity_price = 1500;
		$this->assertEquals($price, $pricing->get_price($product, 1));

		$price->quantity_price = 2400;
		$price->orig_quantity_price = 3000;
		$this->assertEquals($price, $pricing->get_price($product, 2));

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
		$catalog_promotion->discount_value = 100;
		$catalog_promotion->start = new \DateTime('2014-01-01');
		$catalog_promotion->end = new \DateTime('2014-12-31');

		$pricing = new Pricing(new \DateTime('2014-02-01'));
		$pricing->add_catalog_promotion($catalog_promotion);

		$product = $this->_setup_product();

		$price = new Price;
		$price->unit_price = 1400;
		$price->orig_unit_price = 1500;
		$price->catalog_promotions = [$catalog_promotion];

		$price->quantity_price = 1400;
		$price->orig_quantity_price = 1500;
		$this->assertEquals($price, $pricing->get_price($product, 1));

		$price->quantity_price = 2800;
		$price->orig_quantity_price = 3000;
		$this->assertEquals($price, $pricing->get_price($product, 2));

		$price->quantity_price = 14000;
		$price->orig_quantity_price = 15000;
		$this->assertEquals($price, $pricing->get_price($product, 10));
	}

	/**
	 * @covers Pricing::get_price
	 */
	public function test_get_price_with_catalog_promotion_percent_tag()
	{
		$tag = new Tag;
		$tag->id = 1;
		$tag->name = 'Test Tag';

		$catalog_promotion = new CatalogPromotion;
		$catalog_promotion->name = '20% Off';
		$catalog_promotion->discount_type = 'percent';
		$catalog_promotion->discount_value = 20;
		$catalog_promotion->tag = $tag;
		$catalog_promotion->start = new \DateTime('2014-01-01');
		$catalog_promotion->end = new \DateTime('2014-12-31');

		$pricing = new Pricing(new \DateTime('2014-02-01'));
		$pricing->add_catalog_promotion($catalog_promotion);

		$product = $this->_setup_product();

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
		$price->catalog_promotions = [$catalog_promotion];
		$this->assertEquals($price, $pricing->get_price($product, 2));
	}
}
