<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartByUserIdQuery;
use inklabs\kommerce\Action\Cart\Query\GetCartByUserIdResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetCartByUserIdHandler implements QueryHandlerInterface
{
    /** @var GetCartByUserIdQuery */
    private $query;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetCartByUserIdQuery $query,
        CartRepositoryInterface $cartRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->cartRepository = $cartRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageUser($this->query->getUserId());
    }

    public function handle()
    {
        $response = new GetCartByUserIdResponse();

        $cart = $this->cartRepository->findOneByUserId(
            $this->query->getUserId()
        );

        $response->setCartDTOBuilder(
            $this->dtoBuilderFactory->getCartDTOBuilder($cart)
        );

        return $response;
    }
}
