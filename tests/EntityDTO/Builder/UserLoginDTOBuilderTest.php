<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class UserLoginDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $userLogin = $this->dummyData->getUserLogin();
        $userLogin->setUser($this->dummyData->getUser());
        $userLogin->setUserToken($this->dummyData->getUserToken());

        $userLogin = $userLogin->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($userLogin instanceof UserLoginDTO);
        $this->assertTrue($userLogin->user instanceof UserDTO);
        $this->assertTrue($userLogin->userToken instanceof UserTokenDTO);
    }
}
