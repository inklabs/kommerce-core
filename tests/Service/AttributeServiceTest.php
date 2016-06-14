<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class AttributeServiceTest extends ServiceTestCase
{
    /** @var AttributeRepositoryInterface | \Mockery\Mock */
    protected $attributeRepository;

    /** @var AttributeService */
    protected $attributeService;

    public function setUp()
    {
        parent::setUp();
        $this->attributeRepository = $this->mockRepository->getAttributeRepository();
        $this->attributeService = new AttributeService($this->attributeRepository);
    }

    public function testCRUD()
    {
        $this->executeServiceCRUD(
            $this->attributeService,
            $this->attributeRepository,
            $this->dummyData->getAttribute()
        );
    }

    public function testFindOneById()
    {
        $attribute1 = $this->dummyData->getAttribute();

        $this->attributeRepository->shouldReceive('findOneById')
            ->with($attribute1->getId())
            ->andReturn($attribute1)
            ->once();

        $attribute = $this->attributeService->findOneById($attribute1->getId());

        $this->assertSame($attribute1, $attribute);
    }
}
