<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartSessionIdCommand;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class SetCartSessionIdHandler implements CommandHandlerInterface
{
    /** @var SetCartSessionIdCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    public function __construct(
        SetCartSessionIdCommand $command,
        CartRepositoryInterface $cartRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->command = $command;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageCart($this->command->getCartId());
    }

    public function handle()
    {
        $cart = $this->cartRepository->findOneById($this->command->getCartId());
        $cart->setSessionId($this->command->getSessionId());

        $this->cartRepository->update($cart);
    }
}
