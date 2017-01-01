<?php
namespace inklabs\kommerce\Action\Attribute\Query;

use inklabs\kommerce\EntityDTO\Builder\AttributeValueDTOBuilder;

class GetAttributeValueResponse implements GetAttributeValueResponseInterface
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
