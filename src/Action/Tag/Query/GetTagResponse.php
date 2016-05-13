<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\EntityDTO\TagDTO;

class GetTagResponse implements GetTagResponseInterface
{
    /** @var TagDTO */
    protected $tagDTO;

    public function setTagDTO(TagDTO $tagDTO)
    {
        $this->tagDTO = $tagDTO;
    }

    public function getTagDTO()
    {
        return $this->tagDTO;
    }
}
