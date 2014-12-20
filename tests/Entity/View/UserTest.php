<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUser = new Entity\User;
        $entityUser->addToken(new Entity\UserToken);
        $entityUser->addRole(new Entity\UserRole);
        $entityUser->addLogin(new Entity\UserLogin);

        $user = $entityUser->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($user instanceof User);
        $this->assertTrue($user->roles[0] instanceof UserRole);
        $this->assertTrue($user->tokens[0] instanceof UserToken);
        $this->assertTrue($user->logins[0] instanceof UserLogin);
    }
}
