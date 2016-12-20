<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\UnsetDefaultImageForTagCommand;
use inklabs\kommerce\Service\TagServiceInterface;

final class UnsetDefaultImageForTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(UnsetDefaultImageForTagCommand $command)
    {
        $tag = $this->tagService->findOneById($command->getTagId());

        $tag->setDefaultImage(null);

        $this->tagService->update($tag);
    }
}
