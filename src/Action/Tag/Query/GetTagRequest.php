<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetTagRequest
{
    /** @var UuidInterface */
    private $tagId;

    /**
     * @param string $tagIdString
     */
    public function __construct($tagIdString)
    {
        $this->tagId = Uuid::fromString($tagIdString);
    }

    public function getTagId()
    {
        return $this->tagId;
    }
}
