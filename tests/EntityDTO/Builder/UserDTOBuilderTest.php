<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class UserDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $user = $this->dummyData->getUser();
        $user->addUserToken($this->dummyData->getUserToken());
        $user->addUserRole($this->dummyData->getUserRole());
        $user->addUserLogin($this->dummyData->getUserLogin());

        $userDTO = $this->getDTOBuilderFactory()
            ->getUserDTOBuilder($user)
            ->withAllData()
            ->build();

        $this->assertTrue($userDTO instanceof UserDTO);
        $this->assertTrue($userDTO->status instanceof UserStatusTypeDTO);
        $this->assertTrue($userDTO->userRoles[0] instanceof UserRoleDTO);
        $this->assertTrue($userDTO->userTokens[0] instanceof UserTokenDTO);
        $this->assertTrue($userDTO->userLogins[0] instanceof UserLoginDTO);
    }
}
