<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

abstract class AbstractWriteTagCommand implements CommandInterface
{
    /** @var TagDTO */
    private $tagDTO;

    public function __construct(TagDTO $tagDTO)
    {
        $this->tagDTO = $tagDTO;
    }

    public function getTagDTO()
    {
        return $this->tagDTO;
    }
}
