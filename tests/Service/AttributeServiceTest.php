<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeAttributeRepository;

class AttributeServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeAttributeRepository */
    protected $attributeRepository;

    /** @var AttributeService */
    protected $attributeService;

    public function setUp()
    {
        $this->attributeRepository = new FakeAttributeRepository;
        $this->attributeService = new AttributeService($this->attributeRepository);
    }

    public function testCreate()
    {
        $attribute = $this->getDummyAttribute();
        $this->attributeService->create($attribute);
        $this->assertTrue($attribute instanceof Attribute);
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
        $this->assertTrue($attributeValue instanceof Attribute);
    }

    public function testFindMissing()
    {
        $this->attributeRepository->setReturnValue(null);

        $attributeValue = $this->attributeService->find(1);
        $this->assertSame(null, $attributeValue);
    }
}
