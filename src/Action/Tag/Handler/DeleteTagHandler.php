<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\DeleteTagCommand;

class DeleteTagHandler extends AbstractTagHandler
{
    public function handle(DeleteTagCommand $command)
    {
        $this->tagService->delete($command->getId());
    }
}
