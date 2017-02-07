<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\CreateCartCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class CreateCartHandler implements CommandHandlerInterface
{
    /** @var CreateCartCommand */
    private $command;

    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(
        CreateCartCommand $command,
        CartServiceInterface $cartService
    ) {
        $this->command = $command;
        $this->cartService = $cartService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $this->cartService->create(
            $this->command->getCartId(),
            $this->command->getRemoteIp4(),
            $this->command->getUserId(),
            $this->command->getSessionId()
        );
    }
}
