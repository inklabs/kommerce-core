<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\AttributeValue;

class AttributeValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers AttributeValue::__construct
     */
    public function testConstruct()
    {
        $attribute_value = new AttributeValue;
        $attribute_value->id = 1;
        $attribute_value->sku = 'TA';
        $attribute_value->name = 'Test Attribute';
        $attribute_value->description = 'Test attribute description';
        $attribute_value->sort_order = 0;
        $attribute_value->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $attribute_value->updated = null;

        $this->assertEquals(1, $attribute_value->id);
    }
}
