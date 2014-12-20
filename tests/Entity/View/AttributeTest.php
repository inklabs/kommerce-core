<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityAttribute = new Entity\Attribute;
        $entityAttribute->addAttributeValue(new Entity\AttributeValue);

        $attribute = $entityAttribute->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($attribute instanceof Attribute);
        $this->assertTrue($attribute->attributeValues[0] instanceof AttributeValue);
    }
}
