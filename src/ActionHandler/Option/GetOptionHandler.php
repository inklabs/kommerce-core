<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\GetOptionQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetOptionHandler implements QueryHandlerInterface
{
    /** @var GetOptionQuery */
    private $query;

    /** @var OptionRepositoryInterface */
    private $optionRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetOptionQuery $query,
        OptionRepositoryInterface $optionRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->optionRepository = $optionRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $product = $this->optionRepository->findOneById(
            $this->query->getRequest()->getOptionId()
        );

        $this->query->getResponse()->setOptionDTOBuilder(
            $this->dtoBuilderFactory->getOptionDTOBuilder($product)
        );
    }
}
