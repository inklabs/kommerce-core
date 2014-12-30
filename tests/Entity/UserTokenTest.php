<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class UserTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userToken = new UserToken;
        $userToken->setUserAgent('UserAgent');
        $userToken->setToken('token');
        $userToken->setType(UserToken::TYPE_GOOGLE);
        $userToken->setExpires(new \DateTime);
        $userToken->setUser(new User);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($userToken));
        $this->assertSame(null, $userToken->getId());
        $this->assertSame('UserAgent', $userToken->getUserAgent());
        $this->assertSame('token', $userToken->getToken());
        $this->assertSame(UserToken::TYPE_GOOGLE, $userToken->getType());
        $this->assertSame('Google', $userToken->getTypeText());
        $this->assertTrue($userToken->getExpires() instanceof \DateTime);
        $this->assertTrue($userToken->getUser() instanceof User);
        $this->assertTrue($userToken->getView() instanceof View\UserToken);
    }

    public function testCreateWithNullExpires()
    {
        $userToken = new UserToken;
        $userToken->setExpires(null);
        $this->assertSame(null, $userToken->getExpires());
    }
}
