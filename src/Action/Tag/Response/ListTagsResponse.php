<?php
namespace inklabs\kommerce\Action\Tag\Response;

use inklabs\kommerce\EntityDTO\TagDTO;

class ListTagsResponse implements ListTagsResponseInterface
{
    /** @var TagDTO[] */
    protected $tagDTOs = [];

    public function addTagDTO(TagDTO $tagDTO)
    {
        $this->tagDTOs[] = $tagDTO;
    }

    public function getTagDTOs()
    {
        return $this->tagDTOs;
    }
}
