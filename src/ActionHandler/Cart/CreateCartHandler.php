<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\CreateCartCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class CreateCartHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(CreateCartCommand $command)
    {
        $this->cartService->create(
            $command->getRemoteIp4(),
            $command->getUserId(),
            $command->getSessionId()
        );
    }
}
