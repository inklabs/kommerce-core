<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Service\TagServiceInterface;

class GetTagHandler
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(GetTagQuery $command)
    {
        return $this->tagService->findOneById($command->getTagId());
    }
}
