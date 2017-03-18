<?php
namespace inklabs\kommerce\ActionResponse\Attribute;

use inklabs\kommerce\EntityDTO\Builder\AttributeValueDTOBuilder;

class GetAttributeValueResponse
{
    /** @var AttributeValueDTOBuilder */
    protected $attributeValueDTOBuilder;

    public function getAttributeValueDTO()
    {
        return $this->attributeValueDTOBuilder
            ->build();
    }

    public function getAttributeValueDTOWithAllData()
    {
        return $this->attributeValueDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setAttributeValueDTOBuilder(AttributeValueDTOBuilder $attributeValueDTOBuilder)
    {
        $this->attributeValueDTOBuilder = $attributeValueDTOBuilder;
    }
}
