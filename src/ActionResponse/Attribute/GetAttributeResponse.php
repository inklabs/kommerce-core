<?php
namespace inklabs\kommerce\ActionResponse\Attribute;

use inklabs\kommerce\EntityDTO\Builder\AttributeDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetAttributeResponse implements ResponseInterface
{
    /** @var AttributeDTOBuilder */
    protected $attributeDTOBuilder;

    public function getAttributeDTO()
    {
        return $this->attributeDTOBuilder
            ->build();
    }

    public function getAttributeDTOWithAttributeValues()
    {
        return $this->attributeDTOBuilder
            ->withAttributeValues()
            ->build();
    }

    public function getAttributeDTOWithAllData()
    {
        return $this->attributeDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setAttributeDTOBuilder(AttributeDTOBuilder $attributeDTOBuilder)
    {
        $this->attributeDTOBuilder = $attributeDTOBuilder;
    }
}
