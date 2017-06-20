<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\UpdateCartItemQuantityCommand;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateCartItemQuantityHandler implements CommandHandlerInterface
{
    /** @var UpdateCartItemQuantityCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    public function __construct(
        UpdateCartItemQuantityCommand $command,
        CartRepositoryInterface $cartRepository
    ) {
        $this->command = $command;
        $this->cartRepository = $cartRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $cartItem = $this->getCartItem();
        $authorizationContext->verifyCanManageCart($cartItem->getCart()->getId());
    }

    public function handle()
    {
        $cartItem = $this->getCartItem();
        $cartItem->setQuantity($this->command->getQuantity());

        $cart = $cartItem->getCart();
        $cart->setShipmentRate(null);

        $this->cartRepository->update($cart);
    }

    /**
     * @return CartItem
     */
    private function getCartItem()
    {
        return $this->cartRepository->getItemById(
            $this->command->getCarItemtId()
        );
    }
}
