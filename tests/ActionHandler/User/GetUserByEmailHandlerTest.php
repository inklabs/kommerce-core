<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserByEmailQuery;
use inklabs\kommerce\Action\User\Query\GetUserByEmailRequest;
use inklabs\kommerce\Action\User\Query\GetUserByEmailResponse;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityDTO\UserDTO;
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
        $request = new GetUserByEmailRequest($user->getEmail());
        $response = new GetUserByEmailResponse();
        $query = new GetUserByEmailQuery($request, $response);

        $this->dispatchQuery($query);
        $this->assertSame($user->getId()->getHex(), $response->getUserDTO()->id->getHex());

        $this->dispatchQuery($query);
        $this->assertSame($user->getId()->getHex(), $response->getUserDTOWithRolesAndTokens()->id->getHex());
    }
}
