<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

class CouponService implements CouponServiceInterface
{
    use EntityValidationTrait;

    /** @var CouponRepositoryInterface */
    private $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function create(Coupon & $coupon)
    {
        $this->throwValidationErrors($coupon);
        $this->couponRepository->create($coupon);
    }

    public function update(Coupon & $coupon)
    {
        $this->throwValidationErrors($coupon);
        $this->couponRepository->update($coupon);
    }

    public function delete(Coupon $coupon)
    {
        $this->couponRepository->delete($coupon);
    }

    /**
     * @param UuidInterface $id
     * @return Coupon
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id)
    {
        return $this->couponRepository->findOneById($id);
    }

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCoupons($queryString = null, Pagination & $pagination = null)
    {
        return $this->couponRepository->getAllCoupons($queryString, $pagination);
    }

    /**
     * @param int[] $couponIds
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCouponsByIds($couponIds, Pagination & $pagination = null)
    {
        return $this->couponRepository->getAllCouponsByIds($couponIds, $pagination);
    }
}
