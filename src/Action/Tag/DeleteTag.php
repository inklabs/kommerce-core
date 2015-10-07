<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Service\TagServiceInterface;

class DeleteTag
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function execute(DeleteTagCommand $command)
    {
        $this->tagService->remove($command->getTagId());
    }
}
