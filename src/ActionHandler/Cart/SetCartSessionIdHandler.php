<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartSessionIdCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class SetCartSessionIdHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(SetCartSessionIdCommand $command)
    {
        $this->cartService->setSessionId(
            $command->getCartId(),
            $command->getSessionId()
        );
    }
}
