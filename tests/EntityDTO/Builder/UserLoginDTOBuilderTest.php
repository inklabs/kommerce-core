<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserToken;

class UserLoginDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $userLogin = new UserLogin;
        $userLogin->setUser(new User);
        $userLogin->setUserToken(new UserToken);

        $userLogin = $userLogin->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($userLogin instanceof UserLoginDTO);
        $this->assertTrue($userLogin->user instanceof UserDTO);
        $this->assertTrue($userLogin->userToken instanceof UserTokenDTO);
    }
}
