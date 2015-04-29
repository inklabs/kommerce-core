<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\tests\Entity\FakeEntity;

class SequentialGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function providerBase()
    {
        return [
            ['0000000000',  null],
            ['0000000000',  0],
            ['0000000001',  1],
            ['2147483647',  2147483647],
            ['4294967295',  4294967295],
            ['9999999999',  9999999999],
            ['99999999999', 99999999999],
        ];
    }

    /**
     * @dataProvider providerBase()
     */
    public function testGenerate($expected, $input)
    {
        $sequentialGenerator = new SequentialGenerator;

        $entity = new FakeEntity;
        $entity->id = $input;

        $sequentialGenerator->generate($entity);

        $this->assertSame($expected, $entity->getReferenceNumber());
    }

    public function testGenerateWithOffset()
    {
        $sequentialGenerator = new SequentialGenerator;
        $sequentialGenerator->setOffset(1000);

        $entity = new FakeEntity;
        $entity->id = 1;

        $sequentialGenerator->generate($entity);

        $expected = '0000001001';
        $this->assertSame($expected, $entity->getReferenceNumber());
    }

    public function testGenerateWithZeroPadLength()
    {
        $sequentialGenerator = new SequentialGenerator;
        $sequentialGenerator->setOffset(1000);
        $sequentialGenerator->setPadLength(0);

        $entity = new FakeEntity;
        $entity->id = 1;

        $sequentialGenerator->generate($entity);

        $expected = '1001';
        $this->assertSame($expected, $entity->getReferenceNumber());
    }
}
