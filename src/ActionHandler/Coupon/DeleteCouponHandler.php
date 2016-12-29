<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\DeleteCouponCommand;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;

final class DeleteCouponHandler
{
    /** @var CouponRepositoryInterface */
    protected $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function handle(DeleteCouponCommand $command)
    {
        $coupon = $this->couponRepository->findOneById($command->getCouponId());
        $this->couponRepository->delete($coupon);
    }
}
