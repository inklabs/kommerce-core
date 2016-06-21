<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCartItemCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class AddCartItemHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(AddCartItemCommand $command)
    {
        $this->cartService->addItem(
            $command->getCartId(),
            $command->getProductId(),
            $command->getQuantity()
        );
    }
}
