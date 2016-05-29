<?php
namespace inklabs\kommerce\Action\Tag\Query;

use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\Lib\Pricing;

class GetTagResponse implements GetTagResponseInterface
{
    /** @var TagDTOBuilder */
    private $tagDTOBuilder;

    /** @var Pricing */
    private $pricing;

    public function __construct(Pricing $pricing)
    {
        $this->pricing = $pricing;
    }

    public function setTagDTOBuilder(TagDTOBuilder $tagDTOBuilder)
    {
        $this->tagDTOBuilder = $tagDTOBuilder;
    }

    public function getTagDTO()
    {
        return $this->tagDTOBuilder
            ->build();
    }

    public function getTagDTOWithAllData()
    {
        return $this->tagDTOBuilder
            ->withAllData($this->pricing)
            ->build();
    }
}
