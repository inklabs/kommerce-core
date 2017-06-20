<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ParcelTest extends EntityTestCase
{
    public function testCreate()
    {
        $parcel = new Parcel;
        $parcel->setExternalId('prcl_xxxxx');
        $parcel->setLength(8.0);
        $parcel->setWidth(6.0);
        $parcel->setHeight(4.0);
        $parcel->setWeight(32);
        $parcel->setPredefinedPackage('SmallFlatRateBox');

        $this->assertSame('prcl_xxxxx', $parcel->getExternalId());
        $this->assertSame('SmallFlatRateBox', $parcel->getPredefinedPackage());
        $this->assertSame(8.0, $parcel->getLength());
        $this->assertSame(6.0, $parcel->getWidth());
        $this->assertSame(4.0, $parcel->getHeight());
        $this->assertSame(32, $parcel->getWeight());
    }
}
