<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\VirtualProduct;

class VirtualProductTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $virtualProduct = new VirtualProduct;
        $virtualProduct->setSku('TST101');
        $virtualProduct->setName('Test Product');
        $virtualProduct->setPrice(500);
        $virtualProduct->setQuantity(10);
        // $virtualProduct->setProduct_group_id(null);
        $virtualProduct->setIsInventoryRequired(true);
        $virtualProduct->setIsPriceVisible(true);
        $virtualProduct->setIsActive(true);
        $virtualProduct->setIsVisible(true);
        $virtualProduct->setIsTaxable(true);
        $virtualProduct->setIsShippable(true);
        $virtualProduct->setShippingWeight(16);
        $virtualProduct->setDescription('Test product description');
        $virtualProduct->setRating(null);
        $virtualProduct->setDefaultImage(null);
        $virtualProduct->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->assertEquals('TST101', $virtualProduct->getSku());
    }
}
