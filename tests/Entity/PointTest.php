<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class PointTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $point = new Point(34.052234, -118.243685);

        $this->assertEntityValid($point);
        $this->assertEquals(34.052234, $point->getLatitude(), '', FLOAT_DELTA);
        $this->assertEquals(-118.243685, $point->getLongitude(), '', FLOAT_DELTA);
    }

    public function testGetGeoBox()
    {
        $point = new Point(34.052234, -118.243685);

        $points = $point->getGeoBox(50);
        $upperLeft = $points[0];
        $bottomRight = $points[1];

        $this->assertEquals(33.3285403, $upperLeft->getLatitude(), '', FLOAT_DELTA);
        $this->assertEquals(-118.9673787, $upperLeft->getLongitude(), '', FLOAT_DELTA);
        $this->assertEquals(34.7759277, $bottomRight->getLatitude(), '', FLOAT_DELTA);
        $this->assertEquals(-117.5199913, $bottomRight->getLongitude(), '', FLOAT_DELTA);
    }
}
