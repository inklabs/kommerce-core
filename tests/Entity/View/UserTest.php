<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUser = new Entity\User;

        $user = User::factory($entityUser)
            ->withAllData()
            ->export();


    }
}
