<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Lib\Command\TagServiceAwareInterface;
use inklabs\kommerce\Service\TagServiceInterface;

abstract class AbstractTagHandler implements TagServiceAwareInterface
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }
}
