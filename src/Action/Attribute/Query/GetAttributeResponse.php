<?php
namespace inklabs\kommerce\Action\Attribute\Query;

use inklabs\kommerce\EntityDTO\Builder\AttributeDTOBuilder;

class GetAttributeResponse implements GetAttributeResponseInterface
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
