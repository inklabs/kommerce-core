<?php
namespace inklabs\kommerce;

class CreatedTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Entity\Product;
    }

    public function testGetters()
    {
        $this->assertInstanceOf('DateTime', $this->product->getCreated());
    }

    public function testEmptyCreated()
    {
        $this->product = new Entity\Product;
        $this->assertInstanceOf('DateTime', $this->product->getCreated());
    }
}
