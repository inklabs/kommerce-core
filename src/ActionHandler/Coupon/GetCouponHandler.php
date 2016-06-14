<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\GetCouponQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CouponServiceInterface;

final class GetCouponHandler
{
    /** @var CouponServiceInterface */
    private $couponService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(CouponServiceInterface $couponService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->couponService = $couponService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetCouponQuery $query)
    {
        $coupon = $this->couponService->findOneById(
            $query->getRequest()->getCouponId()
        );

        $query->getResponse()->setCouponDTOBuilder(
            $this->dtoBuilderFactory->getCouponDTOBuilder($coupon)
        );
    }
}
