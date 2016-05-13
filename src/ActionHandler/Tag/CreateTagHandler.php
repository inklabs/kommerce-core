<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\CreateTagCommand;
use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\Service\TagServiceInterface;

final class CreateTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(CreateTagCommand $command)
    {
        $tag = TagDTOBuilder::createFromDTO($command->getTagDTO());
        $this->tagService->create($tag);
    }
}
