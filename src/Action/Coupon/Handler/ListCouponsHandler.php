<?php
namespace inklabs\kommerce\Action\Coupon\Handler;

use inklabs\kommerce\Action\Coupon\ListCouponsRequest;
use inklabs\kommerce\Action\Coupon\Response\ListCouponsResponseInterface;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Service\CouponServiceInterface;

final class ListCouponsHandler
{
    /** @var CouponServiceInterface */
    private $couponService;

    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function handle(ListCouponsRequest $request, ListCouponsResponseInterface & $response)
    {
        $paginationDTO = $request->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $coupons = $this->couponService->getAllCoupons($request->getQueryString(), $pagination);

        $response->setPaginationDTO(
            $pagination->getDTOBuilder()
                ->build()
        );

        foreach ($coupons as $coupon) {
            $response->addCouponDTO(
                $coupon->getDTOBuilder()
                    ->build()
            );
        }
    }
}
