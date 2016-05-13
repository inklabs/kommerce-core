<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\ListCouponsQuery;
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

    public function handle(ListCouponsQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

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
