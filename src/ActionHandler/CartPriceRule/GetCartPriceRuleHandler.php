<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\GetCartPriceRuleQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetCartPriceRuleHandler implements QueryHandlerInterface
{
    /** @var GetCartPriceRuleQuery */
    private $query;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetCartPriceRuleQuery $query,
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(
            $this->query->getRequest()->getCartPriceRuleId()
        );

        $this->query->getResponse()->setCartPriceRuleDTOBuilder(
            $this->dtoBuilderFactory->getCartPriceRuleDTOBuilder($cartPriceRule)
        );
    }
}
