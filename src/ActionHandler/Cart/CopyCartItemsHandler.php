<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\CopyCartItemsCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class CopyCartItemsHandler implements CommandHandlerInterface
{
    /** @var CopyCartItemsCommand */
    private $command;

    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(
        CopyCartItemsCommand $command,
        CartServiceInterface $cartService
    ) {
        $this->command = $command;
        $this->cartService = $cartService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $this->cartService->copyCartItems(
            $this->command->getFromCartId(),
            $this->command->getToCartId()
        );
    }
}
