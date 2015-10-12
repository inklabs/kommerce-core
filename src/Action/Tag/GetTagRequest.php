<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\QueryInterface;

class GetTagRequest implements QueryInterface
{
    /** @var int */
    private $tagId;

    /**
     * @param int $tagId
     */
    public function __construct($tagId)
    {
        $this->tagId = (int) $tagId;
    }

    public function getTagId()
    {
        return $this->tagId;
    }
}
