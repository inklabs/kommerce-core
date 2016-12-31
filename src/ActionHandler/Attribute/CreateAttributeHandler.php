<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateAttributeCommand;
use inklabs\kommerce\Entity\Attribute;

final class CreateAttributeHandler extends AbstractAttributeHandler
{
    public function handle(CreateAttributeCommand $command)
    {
        $attribute = new Attribute(
            $command->getName(),
            $command->getSortOrder(),
            $command->getAttributeId()
        );

        $this->updateAttributeFromCommand($attribute, $command);

        $this->attributeRepository->create($attribute);
    }
}
