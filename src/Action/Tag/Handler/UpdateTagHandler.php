<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\UpdateTagCommand;

class UpdateTagHandler extends AbstractTagHandler
{
    public function handle(UpdateTagCommand $command)
    {
        $this->tagService->updateFromDTO($command->getTagDTO());
    }
}
