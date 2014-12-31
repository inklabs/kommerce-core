<?php
namespace inklabs\kommerce\Entity;

trait OptionSelector
{
    /* @var Option[] */
    protected $options = [];

    /* @var Product[] */
    protected $products = [];

    public function addOption(Option $option)
    {
        $this->options[] = $option;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function getProducts()
    {
        return $this->products;
    }
}
