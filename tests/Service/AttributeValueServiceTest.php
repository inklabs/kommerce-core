<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeAttributeValueRepository;

class AttributeValueServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeAttributeValueRepository */
    protected $attributeValueRepository;

    /** @var AttributeValueService */
    protected $attributeValueService;

    public function setUp()
    {
        $this->attributeValueRepository = new FakeAttributeValueRepository;
        $this->attributeValueService = new AttributeValueService($this->attributeValueRepository);
    }

    public function testFind()
    {
        $attributeValue = $this->attributeValueService->find(1);
        $this->assertTrue($attributeValue instanceof AttributeValue);
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
        $this->assertTrue($attributeValues[0] instanceof AttributeValue);
    }
}
