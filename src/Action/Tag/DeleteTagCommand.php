<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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
