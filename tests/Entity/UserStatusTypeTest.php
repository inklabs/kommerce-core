<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UserStatusTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(UserStatusType::inactive()->isInactive());
        $this->assertTrue(UserStatusType::active()->isActive());
        $this->assertTrue(UserStatusType::locked()->isLocked());
    }

    public function testGetters()
    {
        $this->assertSame('Inactive', UserStatusType::inactive()->getName());
        $this->assertSame('Active', UserStatusType::active()->getName());
        $this->assertSame('Locked', UserStatusType::locked()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(UserStatusType::createById(UserStatusType::INACTIVE)->isInactive());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        UserStatusType::createById(999);
    }
}
