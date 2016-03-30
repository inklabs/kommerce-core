<?php
namespace inklabs\kommerce\tests\Action\User;

use inklabs\kommerce\Action\User\ChangePasswordCommand;
use inklabs\kommerce\Exception\UserPasswordValidationException;

class ChangePasswordCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidPasswordThrowsException()
    {
        $this->setExpectedException(UserPasswordValidationException::class);
        $command = new ChangePasswordCommand(1, 'xx');
    }
}
