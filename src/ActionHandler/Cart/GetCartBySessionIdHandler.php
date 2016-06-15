<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartBySessionIdQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class GetCartBySessionIdHandler
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

    public function handle(GetCartBySessionIdQuery $query)
    {
        $cart = $this->cartService->findBySession(
            $query->getRequest()->getSessionId()
        );

        $query->getResponse()->setCartDTOBuilder(
            $this->dtoBuilderFactory->getCartDTOBuilder($cart)
        );
    }
}
