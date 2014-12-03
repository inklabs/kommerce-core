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

        $this->assertEquals(1, $option->getId());
        $this->assertEquals('Size', $option->getname());
        $this->assertEquals('radio', $option->getType());
        $this->assertEquals('Shirt Size', $option->getDescription());
        $this->assertEquals(0, $option->getSortOrder());
        $this->assertInstanceOf('inklabs\kommerce\Entity', $option->getProducts()[0]);
    }
}
