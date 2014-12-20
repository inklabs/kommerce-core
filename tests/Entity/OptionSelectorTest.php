<?php
namespace inklabs\kommerce\Entity;

class OptionSelectorTest extends \PHPUnit_Framework_TestCase
{
    public function testAddOption()
    {
        $mock = $this->getMockForTrait('inklabs\kommerce\Entity\OptionSelector');
        $mock->addOption(new Option);
        $this->assertTrue($mock->getOptions()[0] instanceof Option);
    }

    public function testAddProduct()
    {
        $mock = $this->getMockForTrait('inklabs\kommerce\Entity\OptionSelector');
        $mock->addProduct(new Product);
        $this->assertTrue($mock->getProducts()[0] instanceof Product);
    }
}
