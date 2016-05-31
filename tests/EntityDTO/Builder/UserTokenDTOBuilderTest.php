<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class UserTokenDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $userToken = $this->dummyData->getUserToken();

        $userTokenDTO = $this->getDTOBuilderFactory()
            ->getUserTokenDTOBuilder($userToken)
            ->withAllData()
            ->build();

        $this->assertTrue($userTokenDTO instanceof UserTokenDTO);
        $this->assertTrue($userTokenDTO->type instanceof UserTokenTypeDTO);
        $this->assertTrue($userTokenDTO->user instanceof UserDTO);
    }
}
