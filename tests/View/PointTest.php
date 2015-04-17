<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class PointTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPoint = new Entity\Point(37, -118);

        $point = $entityPoint->getView();

        $this->assertTrue($point instanceof Point);
    }
}
