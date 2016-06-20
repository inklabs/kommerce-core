<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCouponToCartCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class AddCouponToCartHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(AddCouponToCartCommand $command)
    {
        $this->cartService->addCouponByCode(
            $command->getCartId(),
            $command->getCouponCode()
        );
    }
}
