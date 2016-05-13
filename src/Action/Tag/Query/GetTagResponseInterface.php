<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\EntityDTO\TagDTO;

interface GetTagResponseInterface
{
    public function setTagDTO(TagDTO $tagDTO);
}
