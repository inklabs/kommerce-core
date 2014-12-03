<?php
namespace inklabs\kommerce\Entity;

class VirtualProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $virtualProduct = new VirtualProduct;
        $this->assertInstanceOf('inklabs\kommerce\Entity\VirtualProduct', $virtualProduct);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Product', $virtualProduct);
    }
}
