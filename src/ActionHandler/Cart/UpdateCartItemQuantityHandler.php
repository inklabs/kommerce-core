<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\UpdateCartItemQuantityCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class UpdateCartItemQuantityHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(UpdateCartItemQuantityCommand $command)
    {
        $this->cartService->updateItemQuantity(
            $command->getCartId(),
            $command->getQuantity()
        );
    }
}
