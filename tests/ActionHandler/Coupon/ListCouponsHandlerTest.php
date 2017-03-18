<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\ListCouponsQuery;
use inklabs\kommerce\ActionResponse\Coupon\ListCouponsResponse;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListCouponsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Coupon::class,
    ];

    public function testHandle()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->persistEntityAndFlushClear($coupon);
        $queryString = 'Coupon';
        $query = new ListCouponsQuery($queryString, new PaginationDTO());

        /** @var ListCouponsResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEntityInDTOList($coupon, $response->getCouponDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
