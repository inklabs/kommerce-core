<?php
namespace inklabs\kommerce\ActionResponse\Tag;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListTagsResponse implements ResponseInterface
{
    /** @var TagDTOBuilder[] */
    private $tagDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    public function addTagDTOBuilder(TagDTOBuilder $tagDTOBuilder): void
    {
        $this->tagDTOBuilders[] = $tagDTOBuilder;
    }

    /**
     * @return TagDTO[]
     */
    public function getTagDTOs(): array
    {
        $tagDTOs = [];
        foreach ($this->tagDTOBuilders as $tagDTOBuilder) {
            $tagDTOs[] = $tagDTOBuilder->build();
        }
        return $tagDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
