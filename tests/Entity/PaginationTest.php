<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class PaginationTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $pagination = new Pagination(10, 1);

        $this->assertSame(10, $pagination->getMaxResults());
        $this->assertSame(1, $pagination->getPage());
        $this->assertSame(null, $pagination->getTotal());
        $this->assertTrue($pagination->isTotalIncluded());
    }

    public function testCreate()
    {
        $pagination = new Pagination(10, 1);
        $pagination->setTotal(100);
        $pagination->setIsTotalIncluded(false);

        $this->assertSame(10, $pagination->getMaxResults());
        $this->assertSame(1, $pagination->getPage());
        $this->assertSame(100, $pagination->getTotal());
        $this->assertFalse($pagination->isTotalIncluded());
    }
}
