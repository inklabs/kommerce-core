<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\EntityRepository as EntityRepository;
use Doctrine\ORM\EntityManager;

class Coupon extends Lib\ServiceManager
{
    /* @var EntityRepository\Coupon */
    private $couponRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->couponRepository = $entityManager->getRepository('kommerce:Coupon');
    }

    /* @return Entity\View\Coupon */
    public function find($id)
    {
        /* @var Entity\Coupon $entityCoupon */
        $entityCoupon = $this->entityManager->getRepository('kommerce:Coupon')->find($id);

        if ($entityCoupon === null) {
            return null;
        }

        return $entityCoupon->getView()
            ->export();
    }

    public function getAllCoupons($queryString = null, Entity\Pagination & $pagination = null)
    {
        $coupons = $this->couponRepository
            ->getAllCoupons($queryString, $pagination);

        return $this->getViewCoupons($coupons);
    }

    public function getAllCouponsByIds($couponIds, Entity\Pagination & $pagination = null)
    {
        $coupons = $this->couponRepository
            ->getAllCouponsByIds($couponIds);

        return $this->getViewCoupons($coupons);
    }

    /**
     * @param Entity\Coupon[] $coupons
     * @return Entity\View\Coupon[]
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
