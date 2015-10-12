<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\CreateTagCommand;

class CreateTagHandler extends AbstractTagHandler
{
    public function handle(CreateTagCommand $command)
    {
        $this->tagService->createFromDTO($command->getTagDTO());
    }
}
