<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\AbstractAttributeCommand;
use inklabs\kommerce\Entity\Attribute;

trait UpdateAttributeHandlerTrait
{
    public function updateAttributeFromCommand(Attribute $attribute, AbstractAttributeCommand $command)
    {
        $attribute->setName($command->getName());
        $attribute->setChoiceType($command->getChoiceType());
        $attribute->setSortOrder($command->getSortOrder());
        $attribute->setDescription($command->getDescription());
    }
}
