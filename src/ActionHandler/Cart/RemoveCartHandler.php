<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\RemoveCartCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class RemoveCartHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(RemoveCartCommand $command)
    {
        $this->cartService->removeCart(
            $command->getCartId()
        );
    }
}
