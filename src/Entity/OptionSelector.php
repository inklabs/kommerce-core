<?php
namespace inklabs\kommerce\Entity;

trait OptionSelector
{
    public $options = [];
    public $selected_option_products = [];

    public function addOption(Option $option)
    {
        $this->options[] = $option;
    }

    public function addSelectedOptionProduct(Product $product)
    {
        $this->selected_option_products[] = $product;
    }
}
