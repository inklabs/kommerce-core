<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ProductAttributeDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $productAttribute = $this->dummyData->getProductAttribute();

        $productAttributeDTO = $productAttribute->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($productAttributeDTO instanceof ProductAttributeDTO);
        $this->assertTrue($productAttributeDTO->product instanceof ProductDTO);
        $this->assertTrue($productAttributeDTO->attribute instanceof AttributeDTO);
        $this->assertTrue($productAttributeDTO->attributeValue instanceof AttributeValueDTO);
    }
}
