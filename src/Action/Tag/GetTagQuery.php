<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetTagQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $tagId;

    public function __construct(string $tagId)
    {
        $this->tagId = Uuid::fromString($tagId);
    }

    public function getTagId(): UuidInterface
    {
        return $this->tagId;
    }
}
