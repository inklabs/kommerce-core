<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeAttribute;

class AttributeTest extends Helper\DoctrineTestCase
{
    /** @var FakeAttribute */
    protected $attributeRepository;

    /** @var Attribute */
    protected $attributeService;

    public function setUp()
    {
        $this->attributeRepository = new FakeAttribute;
        $this->attributeService = new Attribute($this->attributeRepository);
    }

    public function testCreate()
    {
        $attribute = $this->getDummyAttribute();
        $this->attributeService->create($attribute);
        $this->assertTrue($attribute instanceof Entity\Attribute);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $attribute = $this->getDummyAttribute();
        $this->assertNotSame($newName, $attribute->getName());

        $attribute->setName($newName);
        $this->attributeService->edit($attribute);
        $this->assertSame($newName, $attribute->getName());
    }

    public function testFind()
    {
        $attributeValue = $this->attributeService->find(1);
        $this->assertTrue($attributeValue instanceof View\Attribute);
    }

    public function testFindMissing()
    {
        $this->attributeRepository->setReturnValue(null);

        $attributeValue = $this->attributeService->find(1);
        $this->assertSame(null, $attributeValue);
    }
}
