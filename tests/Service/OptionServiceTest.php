<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class OptionServiceTest extends ServiceTestCase
{
    /** @var OptionRepositoryInterface|\Mockery\Mock */
    protected $optionRepository;

    /** @var OptionService */
    protected $optionService;

    public function setUp()
    {
        parent::setUp();
        $this->optionRepository = $this->mockRepository->getOptionRepository();
        $this->optionService = new OptionService($this->optionRepository);
    }

    public function testFind()
    {
        $option1 = $this->dummyData->getOption();
        $this->optionRepository->shouldReceive('findOneById')
            ->with($option1->getId())
            ->andReturn($option1)
            ->once();

        $option = $this->optionService->findOneById(
            $option1->getId()
        );

        $this->assertEntitiesEqual($option1, $option);
    }

    public function testGetAllOptions()
    {
        $option1 = $this->dummyData->getOption();
        $this->optionRepository->shouldReceive('getAllOptions')
            ->andReturn([$option1])
            ->once();

        $options = $this->optionService->getAllOptions();

        $this->assertEntitiesEqual($option1, $options[0]);
    }
}
