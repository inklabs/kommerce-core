<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class PointDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $point = $this->dummyData->getPoint();

        $pointDTO = $point->getDTOBuilder()
            ->build();

        $this->assertTrue($pointDTO instanceof PointDTO);
    }
}
