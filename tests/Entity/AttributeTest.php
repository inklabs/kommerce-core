<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class AttributeTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $attribute = new Attribute;

        $this->assertSame(null, $attribute->getName());
        $this->assertSame(null, $attribute->getDescription());
        $this->assertSame(null, $attribute->getSortOrder());
        $this->assertSame(0, count($attribute->getAttributeValues()));
        $this->assertSame(0, count($attribute->getProductAttributes()));
    }

    public function testCreate()
    {
        $attributeValue = $this->dummyData->getAttributeValue();
        $productAttribute = $this->dummyData->getProductAttribute();

        $attribute = new Attribute;
        $attribute->setName('Test Attribute');
        $attribute->setDescription('Test attribute description');
        $attribute->setSortOrder(0);
        $attribute->addAttributeValue($attributeValue);
        $attribute->addProductAttribute($productAttribute);

        $this->assertEntityValid($attribute);
        $this->assertSame('Test Attribute', $attribute->getName());
        $this->assertSame('Test attribute description', $attribute->getDescription());
        $this->assertSame(0, $attribute->getSortOrder());
        $this->assertSame($attributeValue, $attribute->getAttributeValues()[0]);
        $this->assertSame($productAttribute, $attribute->getProductAttributes()[0]);
    }
}
