<?php
namespace inklabs\kommerce\Action\Tag;

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
        $tag = clone $command->getTag();
        $this->tagService->create($tag);
    }
}
