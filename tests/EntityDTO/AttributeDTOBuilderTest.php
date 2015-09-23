<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\ProductAttribute;

class AttributeDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $attribute = new Attribute;
        $attribute->addAttributeValue(new AttributeValue);
        $attribute->addProductAttribute(new ProductAttribute);

        $attributeDTO = $attribute->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($attributeDTO instanceof AttributeDTO);
        $this->assertTrue($attributeDTO->attributeValues[0] instanceof AttributeValueDTO);
        $this->assertTrue($attributeDTO->productAttributes[0] instanceof ProductAttributeDTO);
    }
}
