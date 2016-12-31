<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class AttributeValueTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $attribute = $this->dummyData->getAttribute();
        $name = 'Test Attribute';
        $sortOrder = 12;
        $attributeValue = new AttributeValue($attribute, $name, $sortOrder);

        $this->assertSame(null, $attributeValue->getSku());
        $this->assertSame($name, $attributeValue->getName());
        $this->assertSame(null, $attributeValue->getDescription());
        $this->assertSame($sortOrder, $attributeValue->getSortOrder());
        $this->assertSame($attribute, $attributeValue->getAttribute());
        $this->assertSame(0, count($attributeValue->getProductAttributes()));
    }

    public function testCreate()
    {
        $attribute = $this->dummyData->getAttribute();
        $productAttribute = $this->dummyData->getProductAttribute();
        $name = 'Test Attribute';
        $sortOrder = 12;

        $attributeValue = new AttributeValue($attribute, $name, $sortOrder);
        $attributeValue->setSku('TA');
        $attributeValue->setName('Test Attribute2');
        $attributeValue->setDescription('Test attribute description');
        $attributeValue->setSortOrder(0);
        $attributeValue->addProductAttribute($productAttribute);

        $this->assertEntityValid($attributeValue);
        $this->assertSame('TA', $attributeValue->getSku());
        $this->assertSame('Test Attribute2', $attributeValue->getName());
        $this->assertSame('Test attribute description', $attributeValue->getDescription());
        $this->assertSame(0, $attributeValue->getSortOrder());
        $this->assertSame($attribute, $attributeValue->getAttribute());
        $this->assertSame($productAttribute, $attributeValue->getProductAttributes()[0]);
    }
}
