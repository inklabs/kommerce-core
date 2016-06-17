<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartUserCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class SetCartUserHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(SetCartUserCommand $command)
    {
        $this->cartService->setUserById(
            $command->getCartId(),
            $command->getUserId()
        );
    }
}
