<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserByEmailQuery;
use inklabs\kommerce\ActionResponse\User\GetUserByEmailResponse;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetUserByEmailHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        UserRole::class,
        UserToken::class,
        Cart::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $this->persistEntityAndFlushClear($user);
        $query = new GetUserByEmailQuery($user->getEmail());

        /** @var GetUserByEmailResponse $response */
        $response = $this->dispatchQuery($query);
        $this->assertSame($user->getId()->getHex(), $response->getUserDTO()->id->getHex());

        $response = $this->dispatchQuery($query);
        $this->assertSame($user->getId()->getHex(), $response->getUserDTOWithRolesAndTokens()->id->getHex());
    }
}
