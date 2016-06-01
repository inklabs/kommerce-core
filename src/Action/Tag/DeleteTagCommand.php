<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteTagCommand implements CommandInterface
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
