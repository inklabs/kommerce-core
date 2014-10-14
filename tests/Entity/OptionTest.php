<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\VirtualProduct;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $current_date = new \DateTime('now', new \DateTimeZone('UTC'));

        $option = new Option;
        $option->name = 'Size';
        $option->type = 'radio';
        $option->description = 'Shirt Size';
        $option->created = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->assertEquals('Size', $option->name);
    }

    public function testWithProducts()
    {
        $option = new Option;
        $option->name = 'Size';
        $option->type = 'radio';
        $option->description = 'Navy T-shirt size';

        $product_small = new Product;
        $product_small->setSku('TS-NAVY-SM');
        $product_small->setName('Navy T-shirt (small)');
        $product_small->setPrice(900);

        $product_medium = new Product;
        $product_medium->setSku('TS-NAVY-MD');
        $product_medium->setName('Navy T-shirt (medium)');
        $product_medium->setPrice(1200);

        $product_large = new Product;
        $product_large->setSku('TS-NAVY-LG');
        $product_large->setName('Navy T-shirt (large)');
        $product_large->setPrice(1600);

        $option->addProduct($product_small);
        $option->addProduct($product_medium);
        $option->addProduct($product_large);

        $this->assertEquals('Size', $option->name);
    }

    public function testWithVirtualProducts()
    {
        $current_date = new \DateTime('now', new \DateTimeZone('UTC'));

        $option = new Option;
        $option->name = 'Size';
        $option->type = 'radio';
        $option->description = 'Generic Size';

        $virtual_product_small = new VirtualProduct;
        $virtual_product_small->setSku('SM');
        $virtual_product_small->setName('Small');

        $virtual_product_medium = new VirtualProduct;
        $virtual_product_medium->setSku('MD');
        $virtual_product_medium->setName('Medium');

        $virtual_product_large = new VirtualProduct;
        $virtual_product_large->setSku('LG');
        $virtual_product_large->setName('Large');

        $option->addProduct($virtual_product_small);
        $option->addProduct($virtual_product_medium);
        $option->addProduct($virtual_product_large);

        $this->assertEquals('Size', $option->name);
    }
}
