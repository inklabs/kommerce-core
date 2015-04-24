<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\EntityRepository\FakeAttribute;

class AttributeTest extends Helper\DoctrineTestCase
{
    /** @var FakeAttribute */
    protected $repository;

    /** @var Attribute */
    protected $service;

    public function setUp()
    {
        $this->repository = new FakeAttribute;
        $this->service = new Attribute($this->repository);
    }

    public function testFind()
    {
        $attributeValue = $this->service->find(1);
        $this->assertTrue($attributeValue instanceof View\Attribute);
    }

    public function testFindMissing()
    {
        $this->repository->setReturnValue(null);

        $attributeValue = $this->service->find(1);
        $this->assertSame(null, $attributeValue);
    }
}
