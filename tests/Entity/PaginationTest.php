<?php
namespace inklabs\kommerce\Entity;

class PaginationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->pagination = new Pagination(10, 1);
        $this->pagination->setTotal(100);
        $this->pagination->setIsTotalIncluded(true);
    }

    public function testGetData()
    {
        $pagination = $this->pagination->getData();
        $this->assertEquals(10, $pagination->maxResults);
        $this->assertEquals(1, $pagination->page);
        $this->assertEquals(100, $pagination->total);
        $this->assertEquals(true, $pagination->isTotalIncluded);
    }
}
