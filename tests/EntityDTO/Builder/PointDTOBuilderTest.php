<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class PointDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $point = $this->dummyData->getPoint();

        $pointDTO = $this->getDTOBuilderFactory()
            ->getPointDTOBuilder($point)
            ->build();

        $this->assertTrue($pointDTO instanceof PointDTO);
    }
}
