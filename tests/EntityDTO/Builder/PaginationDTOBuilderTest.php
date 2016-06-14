<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class PaginationDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $pagination = $this->dummyData->getPagination();

        $paginationDTO = $this->getDTOBuilderFactory()
            ->getPaginationDTOBuilder($pagination)
            ->build();

        $this->assertTrue($paginationDTO instanceof PaginationDTO);
    }
}
