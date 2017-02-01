<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\ListCouponsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListCouponsHandler implements QueryHandlerInterface
{
    /** @var ListCouponsQuery */
    private $query;

    /** @var CouponRepositoryInterface */
    private $couponRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListCouponsQuery $query,
        CouponRepositoryInterface $couponRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->couponRepository = $couponRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $request = $this->query->getRequest();
        $response = $this->query->getResponse();

        $paginationDTO = $request->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $coupons = $this->couponRepository->getAllCoupons($request->getQueryString(), $pagination);

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
