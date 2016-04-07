<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OptionProductTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $product = $this->dummyData->getProduct();
        $product->setSku('sku1');
        $product->setName('Test Product');
        $product->setShippingWeight(6);

        $optionProduct = new OptionProduct();
        $optionProduct->setProduct($product);

        $this->assertSame('sku1', $optionProduct->getSku());
        $this->assertSame('Test Product', $optionProduct->getName());
        $this->assertSame(6, $optionProduct->getShippingWeight());
        $this->assertSame(null, $optionProduct->getSortOrder());
        $this->assertSame(null, $optionProduct->getOption());
        $this->assertSame($product, $optionProduct->getProduct());
        $this->assertTrue($optionProduct->getPrice(new Pricing) instanceof Price);
    }

    public function testCreate()
    {
        $option = $this->dummyData->getOption();
        $product = $this->dummyData->getProduct();
        $product->setSku('SM');
        $product->setName('Small Shirt');

        $optionProduct = new OptionProduct();
        $optionProduct->setSortOrder(0);
        $optionProduct->setProduct($product);
        $optionProduct->setOption($option);

        $this->assertEntityValid($optionProduct);
        $this->assertSame('SM', $optionProduct->getSku());
        $this->assertSame('Small Shirt', $optionProduct->getName());
        $this->assertSame(16, $optionProduct->getShippingWeight());
        $this->assertSame(0, $optionProduct->getSortOrder());
        $this->assertTrue($optionProduct->getPrice(new Pricing) instanceof Price);
        $this->assertSame($option, $optionProduct->getOption());
        $this->assertSame($product, $optionProduct->getProduct());
    }
}
