<?php
namespace inklabs\kommerce\ActionResponse\Tag;

use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetTagsByIdsResponse implements ResponseInterface
{
    /** @var TagDTOBuilder[] */
    private $tagDTOBuilders = [];

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
            $tagDTOs[] = $tagDTOBuilder
                ->build();
        }
        return $tagDTOs;
    }
}
