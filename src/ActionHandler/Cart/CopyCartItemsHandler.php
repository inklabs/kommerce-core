<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\CopyCartItemsCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class CopyCartItemsHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(CopyCartItemsCommand $command)
    {
        $this->cartService->copyCartItems(
            $command->getFromCartId(),
            $command->getToCartId()
        );
    }
}
