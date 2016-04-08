<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class PromotionTypeTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $this->assertTrue(PromotionType::fixed()->isFixed());
        $this->assertTrue(PromotionType::percent()->isPercent());
        $this->assertTrue(PromotionType::exact()->isExact());
    }

    public function testGetters()
    {
        $this->assertSame('Fixed', PromotionType::fixed()->getName());
        $this->assertSame('Percent', PromotionType::percent()->getName());
        $this->assertSame('Exact', PromotionType::exact()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(PromotionType::createById(PromotionType::FIXED)->isFixed());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        PromotionType::createById(999);
    }
}
