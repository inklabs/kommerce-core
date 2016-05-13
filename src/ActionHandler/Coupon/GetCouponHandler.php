<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\GetCouponQuery;
use inklabs\kommerce\Service\CouponServiceInterface;

final class GetCouponHandler
{
    /** @var CouponServiceInterface */
    private $couponService;

    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function handle(GetCouponQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

        $coupon = $this->couponService->findOneById($request->getCouponId());

        $response->setCouponDTO(
            $coupon->getDTOBuilder()
                ->build()
        );
    }
}
