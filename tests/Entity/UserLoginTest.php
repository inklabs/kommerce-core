<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class UserLoginTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userLogin = new UserLogin;
        $userLogin->setEmail('test@example.com');
        $userLogin->setIp4('8.8.8.8');
        $userLogin->setResult(UserLogin::RESULT_SUCCESS);
        $userLogin->setUser(new User);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($userLogin));
        $this->assertSame('test@example.com', $userLogin->getEmail());
        $this->assertSame('8.8.8.8', $userLogin->getIp4());
        $this->assertSame(UserLogin::RESULT_SUCCESS, $userLogin->getResult());
        $this->assertSame('Success', $userLogin->getResultText());
        $this->assertTrue($userLogin->getUser() instanceof User);
        $this->assertTrue($userLogin->getView() instanceof View\UserLogin);
    }
}
