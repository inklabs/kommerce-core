<?php
namespace inklabs\kommerce\ActionResponse\Attribute;

use inklabs\kommerce\EntityDTO\AttributeDTO;
use inklabs\kommerce\EntityDTO\Builder\AttributeDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetAttributeResponse implements ResponseInterface
{
    /** @var AttributeDTOBuilder */
    protected $attributeDTOBuilder;

    public function getAttributeDTO(): AttributeDTO
    {
        return $this->attributeDTOBuilder
            ->build();
    }

    public function getAttributeDTOWithAttributeValues(): AttributeDTO
    {
        return $this->attributeDTOBuilder
            ->withAttributeValues()
            ->build();
    }

    public function getAttributeDTOWithAllData(): AttributeDTO
    {
        return $this->attributeDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setAttributeDTOBuilder(AttributeDTOBuilder $attributeDTOBuilder): void
    {
        $this->attributeDTOBuilder = $attributeDTOBuilder;
    }
}
