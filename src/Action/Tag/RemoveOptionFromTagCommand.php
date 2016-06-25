<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class RemoveOptionFromTagCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $tagId;

    /** @var UuidInterface */
    private $optionId;

    /**
     * @param string $tagId
     * @param string $optionId
     */
    public function __construct($tagId, $optionId)
    {
        $this->tagId = Uuid::fromString($tagId);
        $this->optionId = Uuid::fromString($optionId);
    }

    public function getTagId()
    {
        return $this->tagId;
    }

    public function getOptionId()
    {
        return $this->optionId;
    }
}
