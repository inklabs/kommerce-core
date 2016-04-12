<?php
namespace inklabs\kommerce\Action\Tag\Response;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\TagDTO;

final class ListTagsResponse implements ListTagsResponseInterface
{
    /** @var TagDTO[] */
    protected $tagDTOs = [];

    /** @var PaginationDTO */
    protected $paginationDTO;

    public function addTagDTO(TagDTO $tagDTO)
    {
        $this->tagDTOs[] = $tagDTO;
    }

    public function getTagDTOs()
    {
        return $this->tagDTOs;
    }

    public function setPaginationDTO(PaginationDTO $paginationDTO)
    {
        $this->paginationDTO = $paginationDTO;
    }

    public function getPaginationDTO()
    {
        return $this->paginationDTO;
    }
}
