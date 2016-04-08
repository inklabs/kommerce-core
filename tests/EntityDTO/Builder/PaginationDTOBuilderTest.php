<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class PaginationDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $pagination = $this->dummyData->getPagination();

        $paginationDTO = $pagination->getDTOBuilder()
            ->build();

        $this->assertTrue($paginationDTO instanceof PaginationDTO);
    }
}
