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

    public function testGetOptionValueById()
    {
        $optionValue1 = $this->dummyData->getOptionValue();
        $this->optionRepository->shouldReceive('getOptionValueById')
            ->with($optionValue1->getId())
            ->andReturn($optionValue1)
            ->once();

        $option = $this->optionService->getOptionValueById(
            $optionValue1->getId()
        );

        $this->assertEntitiesEqual($optionValue1, $option);
    }

    public function testGetOptionProductById()
    {
        $optionProduct1 = $this->dummyData->getOptionProduct();
        $this->optionRepository->shouldReceive('getOptionProductById')
            ->with($optionProduct1->getId())
            ->andReturn($optionProduct1)
            ->once();

        $option = $this->optionService->getOptionProductById(
            $optionProduct1->getId()
        );

        $this->assertEntitiesEqual($optionProduct1, $option);
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
