<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UserLoginResultTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(UserLoginResultType::fail()->isFail());
        $this->assertTrue(UserLoginResultType::success()->isSuccess());
    }

    public function testGetters()
    {
        $this->assertSame('Fail', UserLoginResultType::fail()->getName());
        $this->assertSame('Success', UserLoginResultType::success()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(UserLoginResultType::createById(UserLoginResultType::FAIL)->isFail());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        UserLoginResultType::createById(999);
    }
}
