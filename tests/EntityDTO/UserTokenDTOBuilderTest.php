<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserToken;

class UserTokenDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityUserToken = new UserToken;
        $entityUserToken->setUser(new User);

        $userToken = $entityUserToken->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($userToken instanceof UserTokenDTO);
        $this->assertTrue($userToken->user instanceof UserDTO);
    }
}
