<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;

interface GetTagResponseInterface
{
    public function setTagDTOBuilder(TagDTOBuilder $tagDTOBuilder);
}
