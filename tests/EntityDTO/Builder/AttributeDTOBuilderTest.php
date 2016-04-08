<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class AttributeDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $attribute = $this->dummyData->getAttribute();
        $attribute->addProductAttribute($this->dummyData->getProductAttribute());
        $attribute->addAttributeValue($this->dummyData->getAttributeValue());

        $attributeDTO = $attribute->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($attributeDTO instanceof AttributeDTO);
        $this->assertTrue($attributeDTO->attributeValues[0] instanceof AttributeValueDTO);
        $this->assertTrue($attributeDTO->productAttributes[0] instanceof ProductAttributeDTO);
    }
}
