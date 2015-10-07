<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Service\TagServiceInterface;

class EditTag
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function execute(EditTagCommand $command)
    {
        $tag = $command->getTag();
        $this->tagService->edit($tag);
    }
}
