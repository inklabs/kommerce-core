<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class UserTokenDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $entityUserToken = $this->dummyData->getUserToken();
        $entityUserToken->setUser($this->dummyData->getUser());

        $userToken = $entityUserToken->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($userToken instanceof UserTokenDTO);
        $this->assertTrue($userToken->user instanceof UserDTO);
    }
}
