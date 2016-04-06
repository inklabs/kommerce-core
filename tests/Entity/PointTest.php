<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class PointTest extends DoctrineTestCase
{
    protected $latitude = 34.052234;
    protected $longitude = -118.243685;

    public function testCreateDefaults()
    {
        $point = new Point;

        $this->assertEquals(0.0, $point->getLatitude(), '', FLOAT_DELTA);
        $this->assertEquals(0.0, $point->getLongitude(), '', FLOAT_DELTA);
    }

    public function testCreate()
    {
        $point = new Point($this->latitude, $this->longitude);

        $this->assertEntityValid($point);
        $this->assertEquals($this->latitude, $point->getLatitude(), '', FLOAT_DELTA);
        $this->assertEquals($this->longitude, $point->getLongitude(), '', FLOAT_DELTA);
    }

    public function testGetGeoBox()
    {
        $point = new Point($this->latitude, $this->longitude);

        $points = $point->getGeoBox(50);
        $upperLeft = $points[0];
        $bottomRight = $points[1];

        $this->assertEquals(33.3285403, $upperLeft->getLatitude(), '', FLOAT_DELTA);
        $this->assertEquals(-118.9673787, $upperLeft->getLongitude(), '', FLOAT_DELTA);
        $this->assertEquals(34.7759277, $bottomRight->getLatitude(), '', FLOAT_DELTA);
        $this->assertEquals(-117.5199913, $bottomRight->getLongitude(), '', FLOAT_DELTA);
    }
}
