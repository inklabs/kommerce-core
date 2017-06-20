<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\ListCartPriceRulesQuery;
use inklabs\kommerce\ActionResponse\CartPriceRule\ListCartPriceRulesResponse;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListCartPriceRulesHandler implements QueryHandlerInterface
{
    /** @var ListCartPriceRulesQuery */
    private $query;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListCartPriceRulesQuery $query,
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new ListCartPriceRulesResponse();

        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $cartPriceRules = $this->cartPriceRuleRepository->getAllCartPriceRules(
            $this->query->getQueryString(),
            $pagination
        );

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($cartPriceRules as $cartPriceRule) {
            $response->addCartPriceRuleDTOBuilder(
                $this->dtoBuilderFactory->getCartPriceRuleDTOBuilder($cartPriceRule)
            );
        }

        return $response;
    }
}
