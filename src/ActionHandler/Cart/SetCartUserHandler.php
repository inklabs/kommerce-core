<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartUserCommand;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class SetCartUserHandler implements CommandHandlerInterface
{
    /** @var SetCartUserCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(
        SetCartUserCommand $command,
        CartRepositoryInterface $cartRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->command = $command;
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageCart($this->command->getCartId());
    }

    public function handle()
    {
        $user = $this->userRepository->findOneById($this->command->getUserId());
        $cart = $this->cartRepository->findOneById($this->command->getCartId());
        $cart->setUser($user);

        $this->cartRepository->update($cart);
    }
}
