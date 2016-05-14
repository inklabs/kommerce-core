<?php
namespace inklabs\kommerce\Action\Tag\Query;

final class GetTagRequest
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
