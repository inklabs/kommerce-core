<?php
namespace inklabs\kommerce\ActionResponse\Attribute;

use inklabs\kommerce\EntityDTO\AttributeValueDTO;
use inklabs\kommerce\EntityDTO\Builder\AttributeValueDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetAttributeValueResponse implements ResponseInterface
{
    /** @var AttributeValueDTOBuilder */
    protected $attributeValueDTOBuilder;

    public function getAttributeValueDTO(): AttributeValueDTO
    {
        return $this->attributeValueDTOBuilder
            ->build();
    }

    public function getAttributeValueDTOWithAllData(): AttributeValueDTO
    {
        return $this->attributeValueDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setAttributeValueDTOBuilder(AttributeValueDTOBuilder $attributeValueDTOBuilder): void
    {
        $this->attributeValueDTOBuilder = $attributeValueDTOBuilder;
    }
}
