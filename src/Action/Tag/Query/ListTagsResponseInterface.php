<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;

interface ListTagsResponseInterface
{
    public function setPaginationDTOBuilder(PaginationDTOBuilder$paginationDTOBuilder);
    public function addTagDTOBuilder(TagDTOBuilder $tagDTOBuilder);
}
