<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\EntityRepository;

class Coupon extends Lib\ServiceManager
{
    /** @var EntityRepository\CouponInterface */
    private $couponRepository;

    public function __construct(EntityRepository\CouponInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /* @return View\Coupon */
    public function find($id)
    {
        /** @var Entity\Coupon $entityCoupon */
        $entityCoupon = $this->couponRepository->find($id);

        if ($entityCoupon === null) {
            return null;
        }

        return $entityCoupon->getView()
            ->export();
    }

    public function getAllCoupons($queryString = null, Entity\Pagination & $pagination = null)
    {
        $coupons = $this->couponRepository->getAllCoupons($queryString, $pagination);
        return $this->getViewCoupons($coupons);
    }

    public function getAllCouponsByIds($couponIds, Entity\Pagination & $pagination = null)
    {
        $coupons = $this->couponRepository->getAllCouponsByIds($couponIds, $pagination);
        return $this->getViewCoupons($coupons);
    }

    /**
     * @param Entity\Coupon[] $coupons
     * @return View\Coupon[]
     */
    private function getViewCoupons($coupons)
    {
        $viewCoupons = [];
        foreach ($coupons as $coupon) {
            $viewCoupons[] = $coupon->getView()
                ->export();
        }

        return $viewCoupons;
    }
}
