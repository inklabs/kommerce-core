<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\TagServiceAwareInterface;
use inklabs\kommerce\Service\TagServiceInterface;

class EditTagHandler implements TagServiceAwareInterface
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(EditTagCommand $command)
    {
        $tag = $this->tagService->findOneById($command->id);

        $tag->setName($command->name);
        $tag->setCode($command->code);
        $tag->setDescription($command->description);
        $tag->setIsActive($command->isActive);
        $tag->setIsVisible($command->isVisible);
        $tag->setSortOrder($command->sortOrder);

        $this->tagService->edit($tag);
    }
}
