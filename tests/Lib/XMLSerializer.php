<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\tests\Lib\XMLSerializerTestObject;

class XMLSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetXmlFromObject()
    {
        $object = new XMLSerializerTestObject;
        $object->setId(1);
        $object->setName('Test Object');

        $xmlSerializer = new XMLSerializer;
        $xml = $xmlSerializer->getXml($object);

        $expectedResponse = '<?xml encoding="UTF-8" ?>' .
            '<XMLSerializerTestObject>' .
                '<id>1</id>' .
                '<name>Test Object</name>' .
            '</XMLSerializerTestObject>';

        $this->assertTrue(is_string($xml));
        $this->assertSame($expectedResponse, $xml);
    }
}
