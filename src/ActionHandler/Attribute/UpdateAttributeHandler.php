<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\UpdateAttributeCommand;

final class UpdateAttributeHandler extends AbstractAttributeHandler
{
    public function handle(UpdateAttributeCommand $command)
    {
        $attribute = $this->attributeRepository->findOneById(
            $command->getAttributeId()
        );

        $this->updateAttributeFromCommand($attribute, $command);

        $this->attributeRepository->update($attribute);
    }
}
