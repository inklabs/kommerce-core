<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\TagDTO;

class ListTagsResponse implements ListTagsResponseInterface
{
    /** @var TagDTOBuilder[] */
    private $tagDTOBuilders;

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    public function addTagDTOBuilder(TagDTOBuilder $tagDTOBuilder)
    {
        $this->tagDTOBuilders[] = $tagDTOBuilder;
    }

    /**
     * @return TagDTO[] | \Generator
     */
    public function getTagDTOs()
    {
        foreach ($this->tagDTOBuilders as $tagDTOBuilder) {
            yield $tagDTOBuilder->build();
        }
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
