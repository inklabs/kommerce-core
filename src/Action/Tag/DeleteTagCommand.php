<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteTagCommand implements CommandInterface
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
