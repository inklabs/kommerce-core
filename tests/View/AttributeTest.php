<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityAttribute = new Entity\Attribute;
        $entityAttribute->addAttributeValue(new Entity\AttributeValue);
        $entityAttribute->addProductAttribute(new Entity\ProductAttribute);

        $attribute = $entityAttribute->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($attribute instanceof Attribute);
        $this->assertTrue($attribute->attributeValues[0] instanceof AttributeValue);
    }
}
