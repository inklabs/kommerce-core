<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateAttributeValueCommand;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;

final class CreateAttributeValueHandler
{
    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function handle(CreateAttributeValueCommand $command)
    {
        $attribute = $this->attributeRepository->findOneById($command->getAttributeId());

        $attributeValue = new AttributeValue(
            $attribute,
            $command->getName(),
            $command->getSortOrder(),
            $command->getAttributeValueId()
        );
        $attributeValue->setSku($command->getSku());
        $attributeValue->setDescription($command->getDescription());

        $this->attributeValueRepository->create($attributeValue);
    }
}
