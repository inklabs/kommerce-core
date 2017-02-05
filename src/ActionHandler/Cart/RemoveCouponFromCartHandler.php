<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\RemoveCouponFromCartCommand;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class RemoveCouponFromCartHandler implements CommandHandlerInterface
{
    /** @var RemoveCouponFromCartCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var CouponRepositoryInterface */
    private $couponRepository;

    public function __construct(
        RemoveCouponFromCartCommand $command,
        CartRepositoryInterface $cartRepository,
        CouponRepositoryInterface $couponRepository
    ) {
        $this->command = $command;
        $this->cartRepository = $cartRepository;
        $this->couponRepository = $couponRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageCart($this->command->getCartId());
    }

    public function handle()
    {
        $cart = $this->cartRepository->findOneById($this->command->getCartId());
        $coupon = $this->couponRepository->findOneById($this->command->getCouponId());

        $cart->removeCoupon($coupon);

        $this->cartRepository->update($cart);
    }
}
