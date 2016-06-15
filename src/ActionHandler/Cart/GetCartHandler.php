<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class GetCartHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(CartServiceInterface $cartService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->cartService = $cartService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetCartQuery $query)
    {
        $cart = $this->cartService->findOneById(
            $query->getRequest()->getCartId()
        );

        $query->getResponse()->setCartDTOBuilder(
            $this->dtoBuilderFactory->getCartDTOBuilder($cart)
        );
    }
}
