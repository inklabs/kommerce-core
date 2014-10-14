<?php
namespace inklabs\kommerce\Entity;

trait OptionSelector
{
    private $options = [];
    private $selectedOptionProducts = [];

    public function addOption(Option $option)
    {
        $this->options[] = $option;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function addSelectedOptionProduct(Product $product)
    {
        $this->selectedOptionProducts[] = $product;
    }

    public function getSelectedOptionProducts()
    {
        return $this->selectedOptionProducts;
    }
}
