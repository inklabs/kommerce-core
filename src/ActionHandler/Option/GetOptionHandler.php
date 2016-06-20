<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\GetOptionQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\OptionServiceInterface;

final class GetOptionHandler
{
    /** @var OptionServiceInterface */
    private $optionService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(OptionServiceInterface $optionService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->optionService = $optionService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetOptionQuery $query)
    {
        $product = $this->optionService->findOneById(
            $query->getRequest()->getOptionId()
        );

        $query->getResponse()->setOptionDTOBuilder(
            $this->dtoBuilderFactory->getOptionDTOBuilder($product)
        );
    }
}
