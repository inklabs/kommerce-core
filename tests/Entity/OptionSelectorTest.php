<?php
namespace inklabs\kommerce\Entity;

class OptionSelectorTest extends \PHPUnit_Framework_TestCase
{
    public function testAddOption()
    {
        $mock = $this->getMockForTrait('inklabs\kommerce\Entity\OptionSelector');
        $mock->addOption(new Option);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Option', $mock->getOptions()[0]);
    }

    public function testAddProduct()
    {
        $mock = $this->getMockForTrait('inklabs\kommerce\Entity\OptionSelector');
        $mock->addProduct(new Product);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Product', $mock->getProducts()[0]);
    }
}
