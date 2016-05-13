<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\GetCouponRequest;
use inklabs\kommerce\Action\Coupon\Response\GetCouponResponseInterface;
use inklabs\kommerce\Service\CouponServiceInterface;

final class GetCouponHandler
{
    /** @var CouponServiceInterface */
    private $couponService;

    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function handle(GetCouponRequest $request, GetCouponResponseInterface & $response)
    {
        $coupon = $this->couponService->findOneById($request->getCouponId());

        $response->setCouponDTO(
            $coupon->getDTOBuilder()
                ->build()
        );
    }
}
