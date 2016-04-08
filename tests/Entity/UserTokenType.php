<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UserTokenTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(UserTokenType::internal()->isInternal());
        $this->assertTrue(UserTokenType::google()->isGoogle());
        $this->assertTrue(UserTokenType::facebook()->isFacebook());
        $this->assertTrue(UserTokenType::twitter()->isTwitter());
        $this->assertTrue(UserTokenType::yahoo()->isYahoo());
    }

    public function testGetters()
    {
        $this->assertSame('Internal', UserTokenType::internal()->getName());
        $this->assertSame('Google', UserTokenType::google()->getName());
        $this->assertSame('Facebook', UserTokenType::facebook()->getName());
        $this->assertSame('Twitter', UserTokenType::twitter()->getName());
        $this->assertSame('Yahoo', UserTokenType::yahoo()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(UserTokenType::createById(UserTokenType::INTERNAL)->isInternal());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        UserTokenType::createById(999);
    }
}
