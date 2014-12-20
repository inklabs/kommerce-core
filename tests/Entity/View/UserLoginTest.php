<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class UserLoginTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUserLogin = new Entity\UserLogin;
        $entityUserLogin->setUser(new Entity\User);

        $userLogin = $entityUserLogin->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($userLogin instanceof UserLogin);
        $this->assertTrue($userLogin->user instanceof User);
    }
}
