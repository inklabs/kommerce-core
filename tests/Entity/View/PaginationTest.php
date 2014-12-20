<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class PaginationTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPagination = new Entity\Pagination;

        $pagination = $entityPagination->getView();

        $this->assertTrue($pagination instanceof Pagination);
    }
}
