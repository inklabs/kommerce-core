<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\DeleteCouponCommand;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteCouponHandler implements CommandHandlerInterface
{
    /** @var DeleteCouponCommand */
    private $command;

    /** @var CouponRepositoryInterface */
    protected $couponRepository;

    public function __construct(DeleteCouponCommand $command, CouponRepositoryInterface $couponRepository)
    {
        $this->command = $command;
        $this->couponRepository = $couponRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $coupon = $this->couponRepository->findOneById($this->command->getCouponId());
        $this->couponRepository->delete($coupon);
    }
}
