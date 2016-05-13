<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\CreateOrderFromCartQuery;
use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\EntityDTO\Builder\CreditCardDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\OrderAddressDTOBuilder;
use inklabs\kommerce\Lib\CartCalculatorInterface;
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

    /**
     * @param CreateOrderFromCartQuery $query
     * @throws EntityValidatorException
     */
    public function handle(CreateOrderFromCartQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

        $cart = $this->cartService->findOneById($request->getCartId());

        $order = $this->orderService->createOrderFromCart(
            $cart,
            $this->cartCalculator,
            $request->getIp4(),
            OrderAddressDTOBuilder::createFromDTO($request->getShippingAddressDTO()),
            OrderAddressDTOBuilder::createFromDTO($request->getBillingAddressDTO()),
            CreditCardDTOBuilder::createFromDTO($request->getCreditCardDTO())
        );

        $this->cartService->delete($cart);

        $response->setOrderDTO(
            $order->getDTOBuilder()
                ->build()
        );
    }
}
