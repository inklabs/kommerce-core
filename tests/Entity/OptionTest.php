<?php
namespace inklabs\kommerce\Entity;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setId(1);
        $option->setName('Size');
        $option->setType('radio');
        $option->setDescription('Shirt Size');
        $option->setSortOrder(0);
        $option->addProduct(new Product);

        $this->assertSame(1, $option->getId());
        $this->assertSame('Size', $option->getname());
        $this->assertSame('radio', $option->getType());
        $this->assertSame('Shirt Size', $option->getDescription());
        $this->assertSame(0, $option->getSortOrder());
        $this->assertTrue($option->getProducts()[0] instanceof Product);
        $this->assertTrue($option->getView() instanceof View\Option);
    }
}
