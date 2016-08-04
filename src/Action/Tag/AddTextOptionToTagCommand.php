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

    /**
     * @param string $tagId
     * @param string $textOptionId
     */
    public function __construct($tagId, $textOptionId)
    {
        $this->tagId = Uuid::fromString($tagId);
        $this->textOptionId = Uuid::fromString($textOptionId);
    }

    public function getTagId()
    {
        return $this->tagId;
    }

    public function getTextOptionId()
    {
        return $this->textOptionId;
    }
}
