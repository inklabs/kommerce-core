<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\RemoveCouponFromCartCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class RemoveCouponFromCartHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(RemoveCouponFromCartCommand $command)
    {
        $this->cartService->removeCoupon(
            $command->getCartId(),
            $command->getCouponId()
        );
    }
}
