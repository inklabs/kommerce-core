<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCouponToCartCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class AddCouponToCartHandler implements CommandHandlerInterface
{
    /** @var AddCouponToCartCommand */
    private $command;

    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(
        AddCouponToCartCommand $command,
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
        $this->cartService->addCouponByCode(
            $this->command->getCartId(),
            $this->command->getCouponCode()
        );
    }
}
