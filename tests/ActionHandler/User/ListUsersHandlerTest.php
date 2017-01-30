<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ListUsersQuery;
use inklabs\kommerce\Action\User\Query\ListUsersRequest;
use inklabs\kommerce\Action\User\Query\ListUsersResponse;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListUsersHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        Cart::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $user1 = $this->dummyData->getUser(1);
        $user2 = $this->dummyData->getUser(2);
        $this->persistEntityAndFlushClear([$user1, $user2]);
        $queryString = 'john';
        $request = new ListUsersRequest($queryString, new PaginationDTO);
        $response = new ListUsersResponse();

        $this->dispatchQuery(new ListUsersQuery($request, $response));

        $expectedEntities = [
            $user1,
            $user2,
        ];
        $this->assertEntitiesInDTOList($expectedEntities, $response->getUserDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
