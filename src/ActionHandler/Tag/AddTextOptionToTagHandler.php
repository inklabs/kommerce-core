<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\AddTextOptionToTagCommand;
use inklabs\kommerce\Service\TagServiceInterface;

final class AddTextOptionToTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(AddTextOptionToTagCommand $command)
    {
        $this->tagService->addTextOption(
            $command->getTagId(),
            $command->getTextOptionId()
        );
    }
}
