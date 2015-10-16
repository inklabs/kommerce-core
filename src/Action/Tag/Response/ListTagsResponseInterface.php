<?php
namespace inklabs\kommerce\Action\Tag\Response;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface ListTagsResponseInterface extends ResponseInterface
{
    public function addTagDTO(TagDTO $tagDTO);
    public function getTagDTOs();
    public function setPagination(Pagination $pagination);
    public function getPagination();
}
