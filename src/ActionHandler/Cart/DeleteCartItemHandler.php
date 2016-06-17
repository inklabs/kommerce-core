<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\DeleteCartItemCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class DeleteCartItemHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(DeleteCartItemCommand $command)
    {
        $this->cartService->deleteItem(
            $command->getCartItemId()
        );
    }
}
