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
        $cartItem = $this->cartService->addItem(
            $command->getCartItemId(),
            $command->getCartId(),
            $command->getProductId(),
            $command->getQuantity()
        );

        $optionProductIds = $command->getOptionProductIds();
        $optionValueIds = $command->getOptionValueIds();
        $textOptionValues = $command->getTextOptionValues();

        if (! empty($optionProductIds)) {
            $this->cartService->addItemOptionProducts($cartItem->getId(), $optionProductIds);
        }

        if (! empty($optionValueIds)) {
            $this->cartService->addItemOptionValues($cartItem->getId(), $optionValueIds);
        }

        if (! empty($textOptionValues)) {
            $this->cartService->addItemTextOptionValues($cartItem->getId(), $textOptionValues);
        }
    }
}
