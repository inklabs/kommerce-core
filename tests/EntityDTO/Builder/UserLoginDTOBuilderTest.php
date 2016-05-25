<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class UserLoginDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $user = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken($user);
        $userLogin = $this->dummyData->getUserLogin($user, $userToken);

        $userLogin = $userLogin->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($userLogin instanceof UserLoginDTO);
        $this->assertTrue($userLogin->user instanceof UserDTO);
        $this->assertTrue($userLogin->userToken instanceof UserTokenDTO);
    }
}
