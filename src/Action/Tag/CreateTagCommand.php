<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateTagCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $tagId;

    /** @var TagDTO */
    private $tagDTO;

    public function __construct(TagDTO $tagDTO)
    {
        $this->tagId = Uuid::uuid4();
        $this->tagDTO = $tagDTO;
    }

    public function getTagId()
    {
        return $this->tagId;
    }

    public function getTagDTO()
    {
        return $this->tagDTO;
    }
}
