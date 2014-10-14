<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Product;

class AccessorsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAndCall()
    {
        $product = new Product;
        $product->rating = 500;
        $this->assertEquals(5, $product->__get('rating'));
    }

    /**
     * @expectedException \Exception
     */
    public function testGetMissingProperty()
    {
        $product = new Product;
        $missing = $product->__get('missing');
    }

    public function testSet()
    {
        $product = new Product;
        $product->__set('rating', 500);
        $this->assertEquals(500, $product->rating);
    }

    /**
     * @expectedException \Exception
     */
    public function testSetMissingProperty()
    {
        $product = new Product;
        $product->__set('missing', 1);
    }
}
