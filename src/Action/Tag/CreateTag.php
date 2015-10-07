<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Service\TagServiceInterface;

class CreateTag
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function execute(CreateTagCommand $command)
    {
        $tag = $command->getTag();
        $this->tagService->create($tag);
    }
}
