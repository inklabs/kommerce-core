<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class UserTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUserToken = new Entity\UserToken;
        $entityUserToken->setUser(new Entity\User);

        $userToken = $entityUserToken->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($userToken instanceof UserToken);
        $this->assertTrue($userToken->user instanceof User);
    }
}
