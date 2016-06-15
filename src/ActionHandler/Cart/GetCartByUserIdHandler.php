<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartByUserIdQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class GetCartByUserIdHandler
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

    public function handle(GetCartByUserIdQuery $query)
    {
        $cart = $this->cartService->findByUser(
            $query->getRequest()->getUserId()
        );

        $query->getResponse()->setCartDTOBuilder(
            $this->dtoBuilderFactory->getCartDTOBuilder($cart)
        );
    }
}
