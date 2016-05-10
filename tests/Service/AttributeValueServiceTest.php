<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeAttributeValueRepository;

class AttributeValueServiceTest extends Helper\TestCase\ServiceTestCase
{
    /** @var FakeAttributeValueRepository */
    protected $attributeValueRepository;

    /** @var AttributeValueService */
    protected $attributeValueService;

    public function setUp()
    {
        parent::setUp();
        $this->attributeValueRepository = new FakeAttributeValueRepository;
        $this->attributeValueService = new AttributeValueService($this->attributeValueRepository);
    }

    public function testFind()
    {
        $attribute = $this->dummyData->getAttribute();
        $attributeValue = new AttributeValue($attribute);
        $this->attributeValueRepository->create($attributeValue);
        $attributeValue = $this->attributeValueService->findOneById(1);
        $this->assertTrue($attributeValue instanceof AttributeValue);
    }

    public function testFindMissing()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'AttributeValue not found'
        );

        $this->attributeValueService->findOneById(1);
    }

    public function testGetAttributeValuesByIds()
    {
        $attributeValues = $this->attributeValueService->getAttributeValuesByIds([1]);
        $this->assertTrue($attributeValues[0] instanceof AttributeValue);
    }
}
