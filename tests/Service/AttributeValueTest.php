<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeAttributeValue;

class AttributeValueTest extends Helper\DoctrineTestCase
{
    /** @var FakeAttributeValue */
    protected $attributeValueRepository;

    /** @var AttributeValue */
    protected $attributeValueService;

    public function setUp()
    {
        $this->attributeValueRepository = new FakeAttributeValue;
        $this->attributeValueService = new AttributeValue($this->attributeValueRepository);
    }

    public function testFind()
    {
        $attributeValue = $this->attributeValueService->find(1);
        $this->assertTrue($attributeValue instanceof View\AttributeValue);
    }

    public function testFindMissing()
    {
        $this->attributeValueRepository->setReturnValue(null);

        $attributeValue = $this->attributeValueService->find(1);
        $this->assertSame(null, $attributeValue);
    }

    public function testGetAttributeValuesByIds()
    {
        $attributeValues = $this->attributeValueService->getAttributeValuesByIds([1]);
        $this->assertTrue($attributeValues[0] instanceof View\AttributeValue);
    }
}
