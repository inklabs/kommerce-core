<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\UpdateCouponCommand;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateCouponHandler implements CommandHandlerInterface
{
    use UpdateCouponFromCommandTrait;

    /** @var UpdateCouponCommand */
    private $command;

    /** @var CouponRepositoryInterface */
    private $couponRepository;

    public function __construct(
        UpdateCouponCommand $command,
        CouponRepositoryInterface $couponRepository
    ) {
        $this->couponRepository = $couponRepository;
        $this->command = $command;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $coupon = $this->couponRepository->findOneById(
            $this->command->getCouponId()
        );

        $this->updateCouponFromCommand($coupon, $this->command);

        $this->couponRepository->update($coupon);
    }
}
