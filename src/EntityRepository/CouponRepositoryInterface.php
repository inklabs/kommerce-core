<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

/**
 * @method Coupon findOneById($id)
 */
interface CouponRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $couponCode
     * @return Coupon
     * @throws EntityNotFoundException
     */
    public function findOneByCode($couponCode);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCoupons($queryString = null, Pagination & $pagination = null);

    /**
     * @param UuidInterface[] $couponIds
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCouponsByIds($couponIds, Pagination & $pagination = null);
}
