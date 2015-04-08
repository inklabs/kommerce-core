<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class AttributeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityAttributeValue = new Entity\AttributeValue;
        $entityAttributeValue->setAttribute(new Entity\Attribute);
        $entityAttributeValue->addProductAttribute(new Entity\ProductAttribute);

        $attributeValue = $entityAttributeValue->getView()->withAllData()->export();

        $this->assertTrue($attributeValue instanceof AttributeValue);
        $this->assertTrue($attributeValue->attribute instanceof Attribute);
        $this->assertTrue($attributeValue->productAttributes[0] instanceof ProductAttribute);
    }
}
