<?php
namespace inklabs\kommerce\Entity;

trait OptionSelector
{
	public $options = [];
	public $selected_option_products = [];

	public function add_option(Option $option)
	{
		$this->options[] = $option;
	}

	public function add_selected_option_product(Product $product)
	{
		$this->selected_option_products[] = $product;
	}
}
