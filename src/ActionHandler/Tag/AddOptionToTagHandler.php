<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\AddOptionToTagCommand;
use inklabs\kommerce\Service\TagServiceInterface;

final class AddOptionToTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(AddOptionToTagCommand $command)
    {
        $this->tagService->addOption(
            $command->getTagId(),
            $command->getOptionId()
        );
    }
}
