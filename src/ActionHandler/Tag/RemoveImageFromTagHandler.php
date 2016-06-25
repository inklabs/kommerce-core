<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\RemoveImageFromTagCommand;
use inklabs\kommerce\Service\TagServiceInterface;

final class RemoveImageFromTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(RemoveImageFromTagCommand $command)
    {
        $this->tagService->removeImage(
            $command->getTagId(),
            $command->getImageId()
        );
    }
}
