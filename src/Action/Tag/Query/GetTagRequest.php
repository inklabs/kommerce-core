<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetTagRequest
{
    /** @var UuidInterface */
    private $tagId;

    /**
     * @param string $tagId
     */
    public function __construct($tagId)
    {
        $this->tagId = Uuid::fromString($tagId);
    }

    public function getTagId()
    {
        return $this->tagId;
    }
}
