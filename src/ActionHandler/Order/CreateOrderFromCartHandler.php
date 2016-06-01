<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\CreateOrderFromCartQuery;
use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\EntityDTO\Builder\CreditCardDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
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

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        CartServiceInterface $cartService,
        CartCalculatorInterface $cartCalculator,
        OrderServiceInterface $orderService,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->cartService = $cartService;
        $this->cartCalculator = $cartCalculator;
        $this->orderService = $orderService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
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

        $response->setOrderDTOBuilder(
            $this->dtoBuilderFactory->getOrderDTOBuilder($order)
        );
    }
}
