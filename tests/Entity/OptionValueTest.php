<?php
namespace inklabs\kommerce\Entity;

class OptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $product = new Product;
        $product->setSku('TST');
        $product->setname('Test Product');
        $product->setShippingWeight(16);

        $optionValue = new OptionValue(new Option);

        $this->assertSame(null, $optionValue->getSku());
        $this->assertSame(null, $optionValue->getName());
        $this->assertSame(null, $optionValue->getShippingWeight());

        $optionValue->setSortOrder(0);
        $optionValue->setProduct($product);
        $optionValue->setOption(new Option);

        $this->assertSame(0, $optionValue->getSortOrder());
        $this->assertSame('TST', $optionValue->getSku());
        $this->assertSame('Test Product', $optionValue->getName());
        $this->assertSame(16, $optionValue->getShippingWeight());
        $this->assertTrue($optionValue->getOption() instanceof Option);
        $this->assertTrue($optionValue->getProduct() instanceof Product);
        $this->assertTrue($optionValue->getView() instanceof View\OptionValue);
    }
}
