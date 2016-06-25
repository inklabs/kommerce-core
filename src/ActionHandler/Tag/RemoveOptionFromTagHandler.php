<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\RemoveOptionFromTagCommand;
use inklabs\kommerce\Service\TagServiceInterface;

final class RemoveOptionFromTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(RemoveOptionFromTagCommand $command)
    {
        $this->tagService->removeOption(
            $command->getTagId(),
            $command->getOptionId()
        );
    }
}
