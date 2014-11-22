<?php
namespace inklabs\kommerce\Entity;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->option = new Option;
        $this->option->setName('Size');
        $this->option->setType('radio');
        $this->option->setDescription('Shirt Size');
        $this->option->setSortOrder(0);
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->option->getId());
        $this->assertEquals('Size', $this->option->getName());
        $this->assertEquals('radio', $this->option->getType());
        $this->assertEquals('Shirt Size', $this->option->getDescription());
        $this->assertEquals(0, $this->option->getSortOrder());
    }

    public function testWithProducts()
    {
        $productSmall = new Product;
        $productSmall->setSku('TS-NAVY-SM');
        $productSmall->setName('Navy T-shirt (small)');
        $productSmall->setUnitPrice(900);

        $productMedium = new Product;
        $productMedium->setSku('TS-NAVY-MD');
        $productMedium->setName('Navy T-shirt (medium)');
        $productMedium->setUnitPrice(1200);

        $productLarge = new Product;
        $productLarge->setSku('TS-NAVY-LG');
        $productLarge->setName('Navy T-shirt (large)');
        $productLarge->setUnitPrice(1600);

        $this->option->addProduct($productSmall);
        $this->option->addProduct($productMedium);
        $this->option->addProduct($productLarge);

        $this->assertEquals(3, count($this->option->getProducts()));
    }

    public function testWithVirtualProducts()
    {
        $virtualProductSmall = new VirtualProduct;
        $virtualProductSmall->setSku('SM');
        $virtualProductSmall->setName('Small');

        $virtualProductMedium = new VirtualProduct;
        $virtualProductMedium->setSku('MD');
        $virtualProductMedium->setName('Medium');

        $virtualProductLarge = new VirtualProduct;
        $virtualProductLarge->setSku('LG');
        $virtualProductLarge->setName('Large');

        $this->option->addProduct($virtualProductSmall);
        $this->option->addProduct($virtualProductMedium);
        $this->option->addProduct($virtualProductLarge);

        $this->assertEquals(3, count($this->option->getProducts()));
    }
}
