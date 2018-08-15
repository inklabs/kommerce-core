<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\CreateCouponCommand;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateCouponHandler implements CommandHandlerInterface
{
    use UpdateCouponFromCommandTrait;

    /** @var CreateCouponCommand */
    private $command;

    /** @var CouponRepositoryInterface */
    private $couponRepository;

    public function __construct(
        CreateCouponCommand $command,
        CouponRepositoryInterface $couponRepository
    ) {
        $this->couponRepository = $couponRepository;
        $this->command = $command;
    }
 
    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $coupon = new Coupon(
            $this->command->getCode(),
            $this->command->getCouponId()
        );

        $this->updateCouponFromCommand($coupon, $this->command);

        $this->couponRepository->create($coupon);
    }
}
