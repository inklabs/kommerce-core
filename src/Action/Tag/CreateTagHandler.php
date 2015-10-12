<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Lib\Command\TagServiceAwareInterface;
use inklabs\kommerce\Service\TagServiceInterface;

class CreateTagHandler implements TagServiceAwareInterface
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(CreateTagCommand $command)
    {
        $tag = new Tag;

        $tag->setName($command->name);
        $tag->setCode($command->code);
        $tag->setDescription($command->description);
        $tag->setIsActive($command->isActive);
        $tag->setIsVisible($command->isVisible);
        $tag->setSortOrder($command->sortOrder);

        $this->tagService->create($tag);
    }
}
