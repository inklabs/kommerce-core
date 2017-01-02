<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\UpdateAttributeValueCommand;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;

final class UpdateAttributeValueHandler
{
    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    public function __construct(AttributeValueRepositoryInterface $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function handle(UpdateAttributeValueCommand $command)
    {
        $attributeValue = $this->attributeValueRepository->findOneById(
            $command->getAttributeValueId()
        );

        $attributeValue->setName($command->getName());
        $attributeValue->setSortOrder($command->getSortOrder());
        $attributeValue->setSku($command->getSku());
        $attributeValue->setDescription($command->getDescription());

        $this->attributeValueRepository->update($attributeValue);
    }
}
