<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;

class UserLoginDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUserLogin = new UserLogin;
        $entityUserLogin->setUser(new User);

        $userLogin = $entityUserLogin->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($userLogin instanceof UserLoginDTO);
        $this->assertTrue($userLogin->user instanceof UserDTO);
    }
}
