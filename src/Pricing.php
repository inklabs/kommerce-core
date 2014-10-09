<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\CatalogPromotion;

class Pricing
{
	public $date;
	private $catalog_promotions = [];

	public function __construct(\DateTime $date = NULL)
	{
		if ($date === NULL) {
			$this->date = new \DateTime('now', new \DateTimeZone('UTC'));
		} else {
			$this->date = $date;
		}
	}

	public function add_catalog_promotion(CatalogPromotion $catalog_promotion)
	{
		$this->catalog_promotions[] = $catalog_promotion;
	}

	public function get_price(Product $product, $quantity)
	{
		$price = new Price;
		$price->unit_price = $product->price;
		$price->orig_unit_price = $product->price;
		$price->orig_quantity_price = ($price->orig_unit_price * $quantity);

		// Apply catalog promotions
		foreach ($this->catalog_promotions as $catalog_promotion) {
			if ($catalog_promotion->is_valid($this->date, $product)) {
				$price->unit_price -= $catalog_promotion->get_discount_value($product->price);

				$price->catalog_promotions[] = $catalog_promotion;
			}
		}

		// No prices below zero!
		$price->unit_price = max(0, $price->unit_price);

		$price->quantity_price = ($price->unit_price * $quantity);

		// Add option prices
		foreach ($product->selected_option_products as $option_product) {
			$option_product_price = $this->get_price($option_product, $quantity);

			$price->unit_price          += $option_product_price->unit_price;
			$price->orig_unit_price     += $option_product_price->orig_unit_price;
			$price->orig_quantity_price += $option_product_price->orig_quantity_price;
			$price->quantity_price      += $option_product_price->quantity_price;
		}

		return $price;
	}
}
