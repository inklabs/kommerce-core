<?php
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;

class CatalogPromotionTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers CatalogPromotion::is_tag_valid
	 */
	public function test_is_tag_valid()
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
		$catalog_promotion->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

		$date = new \DateTime('2014-02-01', new DateTimeZone('UTC'));

		$product = new Product;
		$product->sku = 'TST101';
		$product->name = 'Test Product';
		$product->price = 500;

		$product->tags[] = $tag;

		$this->assertTrue($catalog_promotion->is_valid($date, $product));
	}

	/**
	 * @covers CatalogPromotion::is_valid
	 */
	public function test_is_valid()
	{
		$tag = new Tag;
		$tag->id = 1;
		$tag->name = 'Test Tag 1';

		$tag2 = new Tag;
		$tag2->id = 2;
		$tag2->name = 'Test Tag 2';

		$catalog_promotion = new CatalogPromotion;
		$catalog_promotion->name = '20% Off';
		$catalog_promotion->discount_type = 'percent';
		$catalog_promotion->value = 20;
		$catalog_promotion->tag = $tag;
		$catalog_promotion->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
		$catalog_promotion->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

		$date = new \DateTime('2014-02-01', new DateTimeZone('UTC'));

		$product = new Product;
		$product->sku = 'TST101';
		$product->name = 'Test Product';
		$product->price = 500;

		$this->assertFalse($catalog_promotion->is_tag_valid($product));

		$product->tags[] = $tag2;
		$this->assertFalse($catalog_promotion->is_tag_valid($product));

		$product->tags[] = $tag;
		$this->assertTrue($catalog_promotion->is_tag_valid($product));
	}
}
