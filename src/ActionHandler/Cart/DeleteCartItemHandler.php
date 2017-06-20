<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\DeleteCartItemCommand;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class DeleteCartItemHandler implements CommandHandlerInterface
{
    /** @var DeleteCartItemCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(
        DeleteCartItemCommand $command,
        CartRepositoryInterface $cartRepository,
        CartServiceInterface $cartService
    ) {
        $this->command = $command;
        $this->cartRepository = $cartRepository;
        $this->cartService = $cartService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $cartItem = $this->cartRepository->getItemById($this->command->getCartItemId());
        $authorizationContext->verifyCanManageCart($cartItem->getCart()->getId());
    }

    public function handle()
    {
        $this->cartService->deleteItem(
            $this->command->getCartItemId()
        );
    }
}
