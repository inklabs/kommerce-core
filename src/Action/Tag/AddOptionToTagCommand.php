<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class AddOptionToTagCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $tagId;

    /** @var UuidInterface */
    private $optionId;

    public function __construct(string $tagId, string $optionId)
    {
        $this->tagId = Uuid::fromString($tagId);
        $this->optionId = Uuid::fromString($optionId);
    }

    public function getTagId(): UuidInterface
    {
        return $this->tagId;
    }

    public function getOptionId(): UuidInterface
    {
        return $this->optionId;
    }
}
