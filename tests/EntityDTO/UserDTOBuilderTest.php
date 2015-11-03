<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;

class UserDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $user = new User;
        $user->addUserToken(new UserToken);
        $user->addUserRole(new UserRole);
        $user->addUserLogin(new UserLogin);

        $userDTO = $user->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($userDTO instanceof UserDTO);
        $this->assertTrue($userDTO->userRoles[0] instanceof UserRoleDTO);
        $this->assertTrue($userDTO->userTokens[0] instanceof UserTokenDTO);
        $this->assertTrue($userDTO->userLogins[0] instanceof UserLoginDTO);
    }
}
