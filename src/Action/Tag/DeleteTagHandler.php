<?php
namespace inklabs\kommerce\Action\Tag;

class DeleteTagHandler extends AbstractTagHandler
{
    public function handle(DeleteTagCommand $command)
    {
        $this->tagService->delete($command->getTagId());
    }
}
