<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class AddTextOptionToTagCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $tagId;

    /** @var UuidInterface */
    private $textOptionId;

    public function __construct(string $tagId, string $textOptionId)
    {
        $this->tagId = Uuid::fromString($tagId);
        $this->textOptionId = Uuid::fromString($textOptionId);
    }

    public function getTagId(): UuidInterface
    {
        return $this->tagId;
    }

    public function getTextOptionId(): UuidInterface
    {
        return $this->textOptionId;
    }
}
