<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class AttributeValueTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $attribute = $this->dummyData->getAttribute();
        $attributeValue = new AttributeValue($attribute);

        $this->assertSame(null, $attributeValue->getSku());
        $this->assertSame(null, $attributeValue->getName());
        $this->assertSame(null, $attributeValue->getDescription());
        $this->assertSame(null, $attributeValue->getSortOrder());
        $this->assertSame($attribute, $attributeValue->getAttribute());
        $this->assertSame(0, count($attributeValue->getProductAttributes()));
    }

    public function testCreate()
    {
        $attribute = $this->dummyData->getAttribute();
        $productAttribute = $this->dummyData->getProductAttribute();

        $attributeValue = new AttributeValue($attribute);
        $attributeValue->setSku('TA');
        $attributeValue->setName('Test Attribute');
        $attributeValue->setDescription('Test attribute description');
        $attributeValue->setSortOrder(0);
        $attributeValue->addProductAttribute($productAttribute);

        $this->assertEntityValid($attributeValue);
        $this->assertSame('TA', $attributeValue->getSku());
        $this->assertSame('Test Attribute', $attributeValue->getName());
        $this->assertSame('Test attribute description', $attributeValue->getDescription());
        $this->assertSame(0, $attributeValue->getSortOrder());
        $this->assertSame($attribute, $attributeValue->getAttribute());
        $this->assertSame($productAttribute, $attributeValue->getProductAttributes()[0]);
    }
}
