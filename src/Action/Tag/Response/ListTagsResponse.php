<?php
namespace inklabs\kommerce\Action\Tag\Response;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\TagDTO;

class ListTagsResponse implements ListTagsResponseInterface
{
    /** @var TagDTO[] */
    protected $tagDTOs = [];

    /** @var Pagination */
    protected $pagination;

    public function addTagDTO(TagDTO $tagDTO)
    {
        $this->tagDTOs[] = $tagDTO;
    }

    public function getTagDTOs()
    {
        return $this->tagDTOs;
    }

    public function setPagination(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    public function getPagination()
    {
        return $this->pagination;
    }
}
