<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;

final class GetAttributeHandler
{
    /** @var AttributeRepositoryInterface */
    private $attributeRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetAttributeQuery $query)
    {
        $attribute = $this->attributeRepository->findOneById(
            $query->getRequest()->getAttributeId()
        );

        $query->getResponse()->setAttributeDTOBuilder(
            $this->dtoBuilderFactory->getAttributeDTOBuilder($attribute)
        );
    }
}
