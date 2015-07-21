<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;

class Coupon extends AbstractService
{
    /** @var EntityRepository\CouponInterface */
    private $couponRepository;

    public function __construct(EntityRepository\CouponInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function create(Entity\Coupon & $coupon)
    {
        $this->throwValidationErrors($coupon);
        $this->couponRepository->create($coupon);
    }

    public function edit(Entity\Coupon & $coupon)
    {
        $this->throwValidationErrors($coupon);
        $this->couponRepository->save($coupon);
    }

    /**
     * @param int $id
     * @return Entity\Coupon
     */
    public function find($id)
    {
        return $this->couponRepository->find($id);
    }

    public function getAllCoupons($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->couponRepository->getAllCoupons($queryString, $pagination);
    }

    public function getAllCouponsByIds($couponIds, Entity\Pagination & $pagination = null)
    {
        return $this->couponRepository->getAllCouponsByIds($couponIds, $pagination);
    }
}
