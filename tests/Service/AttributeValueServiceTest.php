<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeAttributeValueRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class AttributeValueServiceTest extends ServiceTestCase
{
    /** @var AttributeValueRepositoryInterface | \Mockery\Mock */
    protected $attributeValueRepository;

    /** @var AttributeValueService */
    protected $attributeValueService;

    public function setUp()
    {
        parent::setUp();
        $this->attributeValueRepository = $this->mockRepository->getAttributeValueRepository();
        $this->attributeValueService = new AttributeValueService($this->attributeValueRepository);
    }

    public function testFindOneById()
    {
        $attributeValue1 = $this->dummyData->getAttributeValue();
        $this->attributeValueRepository->shouldReceive('findOneById')
            ->andReturn($attributeValue1)
            ->once();

        $attributeValue = $this->attributeValueService->findOneById(
            $attributeValue1->getId()
        );

        $this->assertEqualEntities($attributeValue1, $attributeValue);
    }

    public function testGetAttributeValuesByIds()
    {
        $attributeValue1 = $this->dummyData->getAttributeValue();
        $this->attributeValueRepository->shouldReceive('getAttributeValuesByIds')
            ->with([$attributeValue1->getId()], null)
            ->andReturn([$attributeValue1])
            ->once();

        $attributeValues = $this->attributeValueService->getAttributeValuesByIds([
            $attributeValue1->getId()
        ]);

        $this->assertEqualEntities($attributeValue1, $attributeValues[0]);
    }
}
