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
        $user->addToken(new UserToken);
        $user->addRole(new UserRole);
        $user->addLogin(new UserLogin);

        $userDTO = $user->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($userDTO instanceof UserDTO);
        $this->assertTrue($userDTO->roles[0] instanceof UserRoleDTO);
        $this->assertTrue($userDTO->tokens[0] instanceof UserTokenDTO);
        $this->assertTrue($userDTO->logins[0] instanceof UserLoginDTO);
    }
}
