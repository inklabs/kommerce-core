<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\TagDTO;

interface ListTagsResponseInterface
{
    public function addTagDTO(TagDTO $tagDTO);
    public function setPaginationDTO(PaginationDTO $paginationDTO);

    /**
     * @return TagDTO[]
     */
    public function getTagDTOs();


    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO();
}
