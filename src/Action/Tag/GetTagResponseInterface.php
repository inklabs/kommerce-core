<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface GetTagResponseInterface extends ResponseInterface
{
    public function setTagDTO(TagDTO $tagDTO);
}
