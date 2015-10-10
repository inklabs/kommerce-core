<?php
namespace inklabs\kommerce\Entity;

class PaginationTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $pagination = new Pagination(10, 1);
        $pagination->setTotal(100);
        $pagination->setIsTotalIncluded(true);

        $expectedResult = new \stdClass;
        $expectedResult->maxResults = 10;
        $expectedResult->page = 1;
        $expectedResult->total = 100;
        $expectedResult->isTotalIncluded = true;

        $this->assertSame(10, $pagination->getMaxResults());
        $this->assertSame(1, $pagination->getPage());
        $this->assertTrue($pagination->isTotalIncluded());
        $this->assertSame(100, $pagination->getTotal());
        $this->assertEquals($expectedResult, $pagination->getData());
    }
}
