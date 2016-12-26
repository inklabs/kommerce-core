<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\ListCartPriceRulesQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CartPriceRuleServiceInterface;

final class ListCartPriceRulesHandler
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

    public function handle(ListCartPriceRulesQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

        $paginationDTO = $request->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $cartPriceRules = $this->cartPriceRuleService->getAllCartPriceRules($request->getQueryString(), $pagination);

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($cartPriceRules as $cartPriceRule) {
            $response->addCartPriceRuleDTOBuilder(
                $this->dtoBuilderFactory->getCartPriceRuleDTOBuilder($cartPriceRule)
            );
        }
    }
}
