<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\GetCartPriceRuleQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CartPriceRuleServiceInterface;

final class GetCartPriceRuleHandler
{
    /** @var CartPriceRuleServiceInterface */
    private $cartPriceRuleService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        CartPriceRuleServiceInterface $cartPriceRuleService,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->cartPriceRuleService = $cartPriceRuleService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetCartPriceRuleQuery $query)
    {
        $cartPriceRule = $this->cartPriceRuleService->findOneById(
            $query->getRequest()->getCartPriceRuleId()
        );

        $query->getResponse()->setCartPriceRuleDTOBuilder(
            $this->dtoBuilderFactory->getCartPriceRuleDTOBuilder($cartPriceRule)
        );
    }
}
