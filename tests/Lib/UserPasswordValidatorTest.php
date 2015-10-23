<?php
namespace inklabs\kommerce\Lib;

use Exception;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class UserPasswordValidatorTest extends DoctrineTestCase
{
    /** @var UserPasswordValidator */
    protected $userPasswordValidator;

    public function setUp()
    {
        parent::setUp();
        $this->userPasswordValidator = new UserPasswordValidator;
    }

    public function testIsPasswordLegal()
    {
        $user = $this->dummyData->getUser();
        $user->setPassword('password2');
        $user->setEmail('ValueInEmail@example1.com');

        $this->assertPasswordValidForUser($user, '', 'Password must be at least 8 characters');
        $this->assertPasswordValidForUser($user, 'password2', 'Invalid password');
        $this->assertPasswordValidForUser($user, 'johndoe1', 'Password is too similar to your name or email');
        $this->assertPasswordValidForUser($user, 'valueinemail', 'Password is too similar to your name or email');
        $this->assertPasswordValidForUser($user, 'example1', 'Password is too similar to your name or email');


        $this->userPasswordValidator->assertPasswordValid($user, 'doejohn1');
        $this->userPasswordValidator->assertPasswordValid($user, 'V3ryStr00ngPa$$word!!');
    }

    private function assertPasswordValidForUser(User $user, $passwordString, $exceptionMessage = null)
    {
        try {
            $this->userPasswordValidator->assertPasswordValid($user, $passwordString);
            $this->fail();
        } catch (Exception $e) {
            $this->assertSame($exceptionMessage, $e->getMessage());
        }
    }
}
