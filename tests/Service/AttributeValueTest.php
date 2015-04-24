<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\EntityRepository\FakeAttributeValue;

class AttributeValueTest extends Helper\DoctrineTestCase
{
    /** @var FakeAttributeValue */
    protected $repository;

    /** @var AttributeValue */
    protected $service;

    public function setUp()
    {
        $this->repository = new FakeAttributeValue;
        $this->service = new AttributeValue($this->repository);
    }

    public function testFind()
    {
        $attributeValue = $this->service->find(1);
        $this->assertTrue($attributeValue instanceof View\AttributeValue);
    }

    public function testFindMissing()
    {
        $this->repository->setReturnValue(null);

        $attributeValue = $this->service->find(1);
        $this->assertSame(null, $attributeValue);
    }

    public function testGetAttributeValuesByIds()
    {
        $attributeValues = $this->service->getAttributeValuesByIds([1]);
        $this->assertTrue($attributeValues[0] instanceof View\AttributeValue);
    }
}
