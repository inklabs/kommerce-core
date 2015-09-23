<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Pagination;

class PaginationDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $pagination = new Pagination;

        $paginationDTO = $pagination->getDTOBuilder()
            ->build();

        $this->assertTrue($paginationDTO instanceof PaginationDTO);
    }
}
