<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ParcelDTOBuilder;

class ParcelTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $parcel = new Parcel;
        $parcel->setExternalId('prcl_xxxxx');
        $parcel->setLength(8.0);
        $parcel->setWidth(6.0);
        $parcel->setHeight(4.0);
        $parcel->setWeight(32);

        $this->assertSame('prcl_xxxxx', $parcel->getExternalId());
        $this->assertSame(8.0, $parcel->getLength());
        $this->assertSame(6.0, $parcel->getWidth());
        $this->assertSame(4.0, $parcel->getHeight());
        $this->assertSame(32, $parcel->getWeight());
        $this->assertTrue($parcel->getDTOBuilder() instanceof ParcelDTOBuilder);
    }

    public function testPredefinedPackage()
    {
        $parcel = new Parcel;
        $parcel->setExternalId('prcl_xxxxx');
        $parcel->setPredefinedPackage('SmallFlatRateBox');

        $this->assertSame('SmallFlatRateBox', $parcel->getPredefinedPackage());
    }
}
