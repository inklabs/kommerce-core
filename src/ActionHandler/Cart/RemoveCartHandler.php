<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\RemoveCartCommand;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class RemoveCartHandler implements CommandHandlerInterface
{
    /** @var RemoveCartCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    public function __construct(
        RemoveCartCommand $command,
        CartRepositoryInterface $cartRepository
    ) {
        $this->command = $command;
        $this->cartRepository = $cartRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanManageCart($this->command->getCartId());
    }

    public function handle()
    {
        $cart = $this->cartRepository->findOneById($this->command->getCartId());
        $this->cartRepository->delete($cart);
    }
}
