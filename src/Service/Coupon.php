<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;

class Coupon extends AbstractService
{
    /** @var CouponRepositoryInterface */
    private $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
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

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\Coupon[]
     */
    public function getAllCoupons($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->couponRepository->getAllCoupons($queryString, $pagination);
    }

    /**
     * @param int[] $couponIds
     * @param Entity\Pagination $pagination
     * @return Entity\Coupon[]
     */
    public function getAllCouponsByIds($couponIds, Entity\Pagination & $pagination = null)
    {
        return $this->couponRepository->getAllCouponsByIds($couponIds, $pagination);
    }
}
