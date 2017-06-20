<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartBySessionIdQuery;
use inklabs\kommerce\ActionResponse\Cart\GetCartBySessionIdResponse;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetCartBySessionIdHandler implements QueryHandlerInterface
{
    /** @var GetCartBySessionIdQuery */
    private $query;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetCartBySessionIdQuery $query,
        CartRepositoryInterface $cartRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->cartRepository = $cartRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanManageCart(
            $this->getCart()->getId()
        );
    }

    public function handle()
    {
        $response = new GetCartBySessionIdResponse();

        $cart = $this->getCart();
        $response->setCartDTOBuilder(
            $this->dtoBuilderFactory->getCartDTOBuilder($cart)
        );

        return $response;
    }

    /**
     * @return Cart
     */
    private function getCart()
    {
        return $this->cartRepository->findOneBySession(
            $this->query->getSessionId()
        );
    }
}
