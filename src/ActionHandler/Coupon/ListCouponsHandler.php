<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\ListCouponsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CouponServiceInterface;

final class ListCouponsHandler
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

    public function handle(ListCouponsQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

        $paginationDTO = $request->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $coupons = $this->couponService->getAllCoupons($request->getQueryString(), $pagination);

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($coupons as $coupon) {
            $response->addCouponDTOBuilder(
                $this->dtoBuilderFactory->getCouponDTOBuilder($coupon)
            );
        }
    }
}
