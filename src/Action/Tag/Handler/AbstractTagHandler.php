<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Service\TagServiceInterface;

abstract class AbstractTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }
}
