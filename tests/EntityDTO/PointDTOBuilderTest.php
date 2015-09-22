<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Point;

class PointDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $point = new Point;

        $pointDTO = $point->getDTOBuilder()
            ->build();

        $this->assertTrue($pointDTO instanceof PointDTO);
    }
}
