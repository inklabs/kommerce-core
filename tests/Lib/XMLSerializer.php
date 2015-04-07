<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\tests\Lib\XMLSerializerTestObject;
use inklabs\kommerce\tests\Lib\XMLSerializerTestObjectGetters;
use inklabs\kommerce\tests\Lib\XMLSerializerTestSingleObject;

class XMLSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param int $num
     * @return XMLSerializerTestSingleObject
     */
    private function getDummySingleObject($num)
    {
        $object = new XMLSerializerTestSingleObject;
        $object->id = $num;
        $object->name = 'Test Object ' . $num;
        return $object;
    }

    public function testGetXmlFromObjectWithPublicProperties()
    {
        $object2 = $this->getDummySingleObject(2);
        $object3 = $this->getDummySingleObject(3);
        $object4 = $this->getDummySingleObject(4);

        $object = new XMLSerializerTestObject;
        $object->id = 1;
        $object->name = 'Test Object 1';
        $object->singleObject = $object2;
        $object->multipleObject = [$object3, $object4];

        $xmlSerializer = new XMLSerializer;
        $xml = $xmlSerializer->getXml($object);

        $expectedResponse = '<?xml version="1.0" encoding="utf-8"?>' .
            '<XMLSerializerTestObject>' .
                '<id>1</id>' .
                '<name>Test Object 1</name>' .
                '<singleObject>' .
                    '<XMLSerializerTestSingleObject>' .
                        '<id>2</id>' .
                        '<name>Test Object 2</name>' .
                    '</XMLSerializerTestSingleObject>' .
                '</singleObject>' .
                '<multipleObject>' .
                    '<XMLSerializerTestSingleObject>' .
                        '<id>3</id>' .
                        '<name>Test Object 3</name>' .
                    '</XMLSerializerTestSingleObject>' .
                    '<XMLSerializerTestSingleObject>' .
                        '<id>4</id>' .
                        '<name>Test Object 4</name>' .
                    '</XMLSerializerTestSingleObject>' .
                '</multipleObject>' .
            '</XMLSerializerTestObject>';

        $this->assertTrue(is_string($xml));
        $this->assertSame($expectedResponse, $xml);
    }
}
