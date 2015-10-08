<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Service\TagServiceInterface;

class GetTag
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function execute(GetTagCommand $command)
    {
        return $this->tagService->findById($command->getTagId());
    }
}
