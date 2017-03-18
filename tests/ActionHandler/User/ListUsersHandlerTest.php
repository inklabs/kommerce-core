<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ListUsersQuery;
use inklabs\kommerce\ActionResponse\User\ListUsersResponse;
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
        $query = new ListUsersQuery($queryString, new PaginationDTO());

        /** @var ListUsersResponse $response */
        $response = $this->dispatchQuery($query);

        $expectedEntities = [
            $user1,
            $user2,
        ];
        $this->assertEntitiesInDTOList($expectedEntities, $response->getUserDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
