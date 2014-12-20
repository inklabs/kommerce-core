<?php
namespace inklabs\kommerce\Entity;

class VirtualProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $virtualProduct = new VirtualProduct;
        $this->assertTrue($virtualProduct instanceof VirtualProduct);
        $this->assertTrue($virtualProduct instanceof Product);
    }
}
