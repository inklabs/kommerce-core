<?php
namespace inklabs\kommerce\Action\Tag;

class CreateTagHandler extends AbstractTagHandler
{
    public function handle(CreateTagCommand $command)
    {
        $this->tagService->createFromDTO($command->getTagDTO());
    }
}
