<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteAttributeCommand;
use inklabs\kommerce\Action\Attribute\DeleteAttributeValueCommand;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;

final class DeleteAttributeValueHandler
{
    /** @var AttributeRepositoryInterface */
    protected $attributeValueRepository;

    public function __construct(AttributeValueRepositoryInterface $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function handle(DeleteAttributeValueCommand $command)
    {
        $attributeValue = $this->attributeValueRepository->findOneById($command->getAttributeValueId());
        $this->attributeValueRepository->delete($attributeValue);
    }
}
