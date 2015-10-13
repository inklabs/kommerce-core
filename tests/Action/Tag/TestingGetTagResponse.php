<?php
namespace inklabs\kommerce\tests\Action\Tag;

use inklabs\kommerce\Action\Tag\GetTagResponseInterface;
use inklabs\kommerce\EntityDTO\TagDTO;

class TestingGetTagResponse implements GetTagResponseInterface
{
    /** @var TagDTO */
    private $tagDTO;

    public function setTagDTO(TagDTO $tagDTO)
    {
        $this->tagDTO = $tagDTO;
    }

    public function getTagDTO()
    {
        return $this->tagDTO;
    }
}
