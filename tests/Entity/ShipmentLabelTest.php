<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ShipmentLabelTest extends EntityTestCase
{
    public function testCreate()
    {
        $shipmentLabel = new ShipmentLabel;
        $shipmentLabel->setExternalId('pl_af0ec9e7299a42b3af5adaa3e18ff7fy');
        $shipmentLabel->setResolution(300);
        $shipmentLabel->setSize('4x6');
        $shipmentLabel->setType('default');
        $shipmentLabel->setFileType('image/png');
        $shipmentLabel->setUrl('http://assets.example.com/file.png');
        $shipmentLabel->setPdfUrl('http://assets.example.com/file.pdf');
        $shipmentLabel->setEpl2Url('http://assets.example.com/file.epl2');
        $shipmentLabel->setZplUrl('http://assets.example.com/file.zpl');

        $this->assertEntityValid($shipmentLabel);
        $this->assertSame('pl_af0ec9e7299a42b3af5adaa3e18ff7fy', $shipmentLabel->getExternalId());
        $this->assertSame(300, $shipmentLabel->getResolution());
        $this->assertSame('4x6', $shipmentLabel->getSize());
        $this->assertSame('default', $shipmentLabel->getType());
        $this->assertSame('image/png', $shipmentLabel->getFileType());
        $this->assertSame('http://assets.example.com/file.png', $shipmentLabel->getUrl());
        $this->assertSame('http://assets.example.com/file.pdf', $shipmentLabel->getPdfUrl());
        $this->assertSame('http://assets.example.com/file.epl2', $shipmentLabel->getEpl2Url());
        $this->assertSame('http://assets.example.com/file.zpl', $shipmentLabel->getZplUrl());
    }
}
