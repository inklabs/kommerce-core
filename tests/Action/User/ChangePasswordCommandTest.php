<?php
namespace inklabs\kommerce\tests\Action\User;

use inklabs\kommerce\Action\User\ChangePasswordCommand;

class ChangePasswordCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \inklabs\kommerce\Entity\UserPasswordException
     */
    public function testInvalidPasswordThrowsException()
    {
        $command = new ChangePasswordCommand(1, 'xx');
    }
}
