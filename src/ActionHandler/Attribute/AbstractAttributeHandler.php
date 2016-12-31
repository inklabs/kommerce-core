<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\AbstractAttributeCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;

abstract class AbstractAttributeHandler
{
    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function updateAttributeFromCommand(Attribute $attribute, AbstractAttributeCommand $command)
    {
        $attribute->setName($command->getName());
        $attribute->setSortOrder($command->getSortOrder());
        $attribute->setDescription($command->getDescription());
    }
}
