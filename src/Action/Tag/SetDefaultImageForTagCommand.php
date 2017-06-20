<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class SetDefaultImageForTagCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $tagId;

    /** @var UuidInterface */
    private $imageId;

    public function __construct(string $tagId, string $imageId)
    {
        $this->tagId = Uuid::fromString($tagId);
        $this->imageId = Uuid::fromString($imageId);
    }

    public function getTagId(): UuidInterface
    {
        return $this->tagId;
    }

    public function getImageId(): UuidInterface
    {
        return $this->imageId;
    }
}
