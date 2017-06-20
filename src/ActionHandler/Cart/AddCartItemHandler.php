<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCartItemCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class AddCartItemHandler implements CommandHandlerInterface
{
    /** @var AddCartItemCommand */
    private $command;

    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(
        AddCartItemCommand $command,
        CartServiceInterface $cartService
    ) {
        $this->command = $command;
        $this->cartService = $cartService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanManageCart($this->command->getCartId());
    }

    public function handle()
    {
        $cartItem = $this->cartService->addItem(
            $this->command->getCartItemId(),
            $this->command->getCartId(),
            $this->command->getProductId(),
            $this->command->getQuantity()
        );

        $optionProductIds = $this->command->getOptionProductIds();
        $optionValueIds = $this->command->getOptionValueIds();
        $textOptionValueDTOs = $this->command->getTextOptionValueDTOs();

        if (! empty($optionProductIds)) {
            $this->cartService->addItemOptionProducts($cartItem->getId(), $optionProductIds);
        }

        if (! empty($optionValueIds)) {
            $this->cartService->addItemOptionValues($cartItem->getId(), $optionValueIds);
        }

        if (! empty($textOptionValueDTOs)) {
            $this->cartService->addItemTextOptionValues($cartItem->getId(), $textOptionValueDTOs);
        }
    }
}
