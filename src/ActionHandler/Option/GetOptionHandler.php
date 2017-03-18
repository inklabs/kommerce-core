<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\GetOptionQuery;
use inklabs\kommerce\ActionResponse\Option\GetOptionResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetOptionHandler implements QueryHandlerInterface
{
    /** @var GetOptionQuery */
    private $query;

    /** @var PricingInterface */
    private $pricing;

    /** @var OptionRepositoryInterface */
    private $optionRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetOptionQuery $query,
        PricingInterface $pricing,
        OptionRepositoryInterface $optionRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->pricing = $pricing;
        $this->optionRepository = $optionRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new GetOptionResponse($this->pricing);

        $product = $this->optionRepository->findOneById(
            $this->query->getOptionId()
        );

        $response->setOptionDTOBuilder(
            $this->dtoBuilderFactory->getOptionDTOBuilder($product)
        );

        return $response;
    }
}
