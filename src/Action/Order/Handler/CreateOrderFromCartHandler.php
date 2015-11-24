<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Action\Order\CreateOrderFromCartCommand;
use inklabs\kommerce\EntityDTO\Builder\CreditCardDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\OrderAddressDTOBuilder;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Service\CartServiceInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class CreateOrderFromCartHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    /** @var CartCalculatorInterface */
    private $cartCalculator;

    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(
        CartServiceInterface $cartService,
        CartCalculatorInterface $cartCalculator,
        OrderServiceInterface $orderService
    ) {
        $this->cartService = $cartService;
        $this->cartCalculator = $cartCalculator;
        $this->orderService = $orderService;
    }

    public function handle(CreateOrderFromCartCommand $command)
    {
        $cart = $this->cartService->findOneById($command->getCartId());

        $this->orderService->createOrderFromCart(
            $cart,
            $this->cartCalculator,
            $command->getIp4(),
            OrderAddressDTOBuilder::createFromDTO($command->getShippingAddressDTO()),
            OrderAddressDTOBuilder::createFromDTO($command->getBillingAddressDTO()),
            CreditCardDTOBuilder::createFromDTO($command->getCreditCardDTO())
        );

        $this->cartService->delete($cart);
    }
}
