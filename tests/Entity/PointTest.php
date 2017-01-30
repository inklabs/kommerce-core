<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class PointTest extends EntityTestCase
{
    protected $latitude = 34.052234;
    protected $longitude = -118.243685;

    public function testCreateDefaults()
    {
        $point = new Point;

        $this->assertFloatEquals(0.0, $point->getLatitude());
        $this->assertFloatEquals(0.0, $point->getLongitude());
    }

    public function testCreate()
    {
        $point = new Point($this->latitude, $this->longitude);

        $this->assertEntityValid($point);
        $this->assertFloatEquals($this->latitude, $point->getLatitude());
        $this->assertFloatEquals($this->longitude, $point->getLongitude());
    }

    public function testGetGeoBox()
    {
        $point = new Point($this->latitude, $this->longitude);

        $points = $point->getGeoBox(50);
        $upperLeft = $points[0];
        $bottomRight = $points[1];

        $this->assertFloatEquals(33.3285403, $upperLeft->getLatitude());
        $this->assertFloatEquals(-118.9673787, $upperLeft->getLongitude());
        $this->assertFloatEquals(34.7759277, $bottomRight->getLatitude());
        $this->assertFloatEquals(-117.5199913, $bottomRight->getLongitude());
    }
}
