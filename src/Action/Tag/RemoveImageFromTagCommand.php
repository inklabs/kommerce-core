<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class RemoveImageFromTagCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $tagId;

    /** @var UuidInterface */
    private $imageId;

    /**
     * @param string $tagId
     * @param string $imageId
     */
    public function __construct($tagId, $imageId)
    {
        $this->tagId = Uuid::fromString($tagId);
        $this->imageId = Uuid::fromString($imageId);
    }

    public function getTagId()
    {
        return $this->tagId;
    }

    public function getImageId()
    {
        return $this->imageId;
    }
}
