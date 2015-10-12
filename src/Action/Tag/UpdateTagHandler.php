<?php
namespace inklabs\kommerce\Action\Tag;

class UpdateTagHandler extends AbstractTagHandler
{
    public function handle(UpdateTagCommand $command)
    {
        $this->tagService->updateFromDTO($command->getTagDTO());
    }
}
