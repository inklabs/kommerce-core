<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserQuery;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetUserHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        UserRole::class,
        UserToken::class,
        Cart::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $this->persistEntityAndFlushClear($user);
        $query = new GetUserQuery($user->getId()->getHex());

        $response = $this->dispatchQuery($query);
        $this->assertSame($user->getId()->getHex(), $response->getUserDTO()->id->getHex());

        $response = $this->dispatchQuery($query);
        $this->assertSame($user->getId()->getHex(), $response->getUserDTOWithRolesAndTokens()->id->getHex());
    }
}
