<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetCartHandler implements QueryHandlerInterface
{
    /** @var GetCartQuery */
    private $query;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetCartQuery $query,
        CartRepositoryInterface $cartRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->cartRepository = $cartRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageCart($this->query->getRequest()->getCartId());
    }

    public function handle()
    {
        $cart = $this->cartRepository->findOneById(
            $this->query->getRequest()->getCartId()
        );

        $this->query->getResponse()->setCartDTOBuilder(
            $this->dtoBuilderFactory->getCartDTOBuilder($cart)
        );
    }
}
