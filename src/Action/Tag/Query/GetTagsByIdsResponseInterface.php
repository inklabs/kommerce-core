<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;

interface GetTagsByIdsResponseInterface
{
    public function addTagDTOBuilder(TagDTOBuilder $tagDTOBuilder);
}
