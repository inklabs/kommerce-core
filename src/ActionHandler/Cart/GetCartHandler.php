<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartQuery;
use inklabs\kommerce\ActionResponse\Cart\GetCartResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetCartHandler implements QueryHandlerInterface
{
    /** @var GetCartQuery */
    private $query;

    /** @var CartCalculator */
    private $cartCalculator;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetCartQuery $query,
        CartCalculator $cartCalculator,
        CartRepositoryInterface $cartRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->cartCalculator = $cartCalculator;
        $this->cartRepository = $cartRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageCart($this->query->getCartId());
    }

    public function handle()
    {
        $response = new GetCartResponse($this->cartCalculator);

        $cart = $this->cartRepository->findOneById(
            $this->query->getCartId()
        );

        $response->setCartDTOBuilder(
            $this->dtoBuilderFactory->getCartDTOBuilder($cart)
        );

        return $response;
    }
}
