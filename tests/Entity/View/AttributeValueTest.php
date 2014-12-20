<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class AttributeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityAttributeValue = new Entity\AttributeValue;

        $attributeValue = $entityAttributeValue->getView();

        $this->assertTrue($attributeValue instanceof AttributeValue);
    }
}
