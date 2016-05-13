<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\Lib\Query\RequestInterface;

final class GetTagRequest implements RequestInterface
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
