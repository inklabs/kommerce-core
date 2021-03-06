<?php
namespace inklabs\kommerce\ActionResponse\Tag;

use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetTagResponse implements ResponseInterface
{
    /** @var TagDTOBuilder */
    private $tagDTOBuilder;

    /** @var Pricing */
    private $pricing;

    public function __construct(Pricing $pricing)
    {
        $this->pricing = $pricing;
    }

    public function setTagDTOBuilder(TagDTOBuilder $tagDTOBuilder): void
    {
        $this->tagDTOBuilder = $tagDTOBuilder;
    }

    public function getTagDTO(): TagDTO
    {
        return $this->tagDTOBuilder
            ->build();
    }

    public function getTagDTOWithAllData(): TagDTO
    {
        return $this->tagDTOBuilder
            ->withAllData($this->pricing)
            ->build();
    }
}
