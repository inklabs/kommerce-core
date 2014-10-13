<?php
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\OptionSelector;

class OptionSelectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers OptionSelector::__construct
     * @covers OptionSelector::add_option
     * @covers OptionSelector::add_selected_option_product
     */
    public function test_add_option()
    {
        $option = new Option;
        $option->name = 'Size';
        $option->type = 'radio';
        $option->description = 'Navy T-shirt size';

        $product_small = new Product;
        $product_small->sku = 'TS-NAVY-SM';
        $product_small->name = 'Navy T-shirt (small)';

        $option->add_product($product_small);

        $product = new Product;
        $product->id = 1;
        $product->sku = 'TST101';
        $product->name = 'Test Product';

        $product->add_option($option);
        $product->add_selected_option_product($product_small);

        $this->assertEquals(1, $product->id);
    }
}
