<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class AttributeDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $attribute = $this->dummyData->getAttribute();
        $attribute->addProductAttribute($this->dummyData->getProductAttribute());
        $attribute->addAttributeValue($this->dummyData->getAttributeValue());

        $attributeDTO = $this->getDTOBuilderFactory()
            ->getAttributeDTOBuilder($attribute)
            ->withAllData()
            ->build();

        $this->assertTrue($attributeDTO instanceof AttributeDTO);
        $this->assertTrue($attributeDTO->attributeValues[0] instanceof AttributeValueDTO);
        $this->assertTrue($attributeDTO->productAttributes[0] instanceof ProductAttributeDTO);
    }
}
