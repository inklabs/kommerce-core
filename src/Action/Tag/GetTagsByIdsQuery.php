<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetTagsByIdsQuery implements QueryInterface
{
    /** @var UuidInterface[] */
    private $tagIds;

    /**
     * @param string[] $tagIds
     */
    public function __construct(array $tagIds)
    {
        $this->setTagIds($tagIds);
    }

    /**
     * @return UuidInterface[]
     */
    public function getTagIds(): array
    {
        return $this->tagIds;
    }

    /**
     * @param string[] $tagIds
     */
    private function setTagIds(array $tagIds)
    {
        $this->tagIds = [];

        foreach ($tagIds as $tagId) {
            $this->tagIds[] = Uuid::fromString($tagId);
        }
    }
}
