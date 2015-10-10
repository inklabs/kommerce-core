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
        $tag = $command->getTag();
        $this->tagService->edit($tag);
    }
}
