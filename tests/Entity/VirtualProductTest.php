<?php
namespace inklabs\kommerce\Entity;

class VirtualProductTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->virtualProduct = new VirtualProduct;
        $this->virtualProduct->setSku('TST101');
        $this->virtualProduct->setName('Test Product');
        $this->virtualProduct->setPrice(500);
        $this->virtualProduct->setQuantity(10);
        $this->virtualProduct->setIsInventoryRequired(true);
        $this->virtualProduct->setIsPriceVisible(true);
        $this->virtualProduct->setIsActive(true);
        $this->virtualProduct->setIsVisible(true);
        $this->virtualProduct->setIsTaxable(true);
        $this->virtualProduct->setIsShippable(true);
        $this->virtualProduct->setShippingWeight(16);
        $this->virtualProduct->setDescription('Test product description');
        $this->virtualProduct->setRating(null);
        $this->virtualProduct->setDefaultImage(null);
        $this->virtualProduct->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetSku()
    {
        $this->assertEquals('TST101', $this->virtualProduct->getSku());
    }
}
