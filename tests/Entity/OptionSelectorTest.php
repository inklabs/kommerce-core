<?php
namespace inklabs\kommerce\Entity;

class OptionSelectorTest extends \PHPUnit_Framework_TestCase
{
    public function testAddOption()
    {
        $option = new Option;
        $option->setName('Size');
        $option->setType('radio');
        $option->setDescription('Navy T-shirt size');

        $productSmall = new Product;
        $productSmall->setSku('TS-NAVY-SM');
        $productSmall->setName('Navy T-shirt (small)');

        $option->addProduct($productSmall);

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');

        $product->addOption($option);
        $product->addSelectedOptionProduct($productSmall);

        $this->assertEquals('TST101', $product->getSku());
        $this->assertEquals(1, count($product->getOptions()));
    }
}
