<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\DeleteTagCommand;
use inklabs\kommerce\Service\TagServiceInterface;

final class DeleteTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(DeleteTagCommand $command)
    {
        $tag = $this->tagService->findOneById($command->getTagId());
        $this->tagService->delete($tag);
    }
}
