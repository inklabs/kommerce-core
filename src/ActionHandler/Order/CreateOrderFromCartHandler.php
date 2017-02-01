<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\CreateOrderFromCartCommand;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityDTO\Builder\CreditCardDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityDTO\Builder\OrderAddressDTOBuilder;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class CreateOrderFromCartHandler implements CommandHandlerInterface
{
    /** @var CreateOrderFromCartCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var CartCalculatorInterface */
    private $cartCalculator;

    /** @var OrderServiceInterface */
    private $orderService;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        CreateOrderFromCartCommand $command,
        CartRepositoryInterface $cartRepository,
        CartCalculatorInterface $cartCalculator,
        OrderServiceInterface $orderService,
        UserRepositoryInterface $userRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartCalculator = $cartCalculator;
        $this->orderService = $orderService;
        $this->userRepository = $userRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
        $this->command = $command;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageUser(
            $this->command->getUserId()
        );
    }

    public function handle()
    {
        $cart = $this->cartRepository->findOneById($this->command->getCartId());
        $user = $this->userRepository->findOneById($this->command->getUserId());

        $order = $this->orderService->createOrderFromCart(
            $this->command->getOrderId(),
            $user,
            $cart,
            $this->cartCalculator,
            $this->command->getIp4(),
            OrderAddressDTOBuilder::createFromDTO($this->command->getShippingAddressDTO()),
            OrderAddressDTOBuilder::createFromDTO($this->command->getBillingAddressDTO()),
            CreditCardDTOBuilder::createFromDTO($this->command->getCreditCardDTO())
        );

        $this->cartRepository->delete($cart);
    }
}
