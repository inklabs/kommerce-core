<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class AttributeValueDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $attributeValue = $this->dummyData->getAttributeValue();
        $attributeValue->addProductAttribute($this->dummyData->getProductAttribute());

        $attributeValueDTO = $attributeValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($attributeValueDTO instanceof AttributeValueDTO);
        $this->assertTrue($attributeValueDTO->attribute instanceof AttributeDTO);
        $this->assertTrue($attributeValueDTO->productAttributes[0] instanceof ProductAttributeDTO);
        $this->assertTrue($attributeValueDTO->productAttributes[0]->product instanceof ProductDTO);
    }
}
