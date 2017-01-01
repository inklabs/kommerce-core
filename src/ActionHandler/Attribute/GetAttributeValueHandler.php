<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeValueQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;

final class GetAttributeValueHandler
{
    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        AttributeValueRepositoryInterface $attributeValueRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->attributeValueRepository = $attributeValueRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetAttributeValueQuery $query)
    {
        $attributeValue = $this->attributeValueRepository->findOneById(
            $query->getRequest()->getAttributeValueId()
        );

        $query->getResponse()->setAttributeValueDTOBuilder(
            $this->dtoBuilderFactory->getAttributeValueDTOBuilder($attributeValue)
        );
    }
}
