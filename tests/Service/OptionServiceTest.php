<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class OptionServiceTest extends ServiceTestCase
{
    /** @var FakeOptionRepository */
    protected $optionRepository;

    /** @var OptionService */
    protected $optionService;

    public function setUp()
    {
        parent::setUp();
        $this->optionRepository = new FakeOptionRepository;
        $this->optionService = new OptionService($this->optionRepository);
    }

    public function testCreate()
    {
        $option = $this->dummyData->getOption();
        $this->optionService->create($option);
        $this->assertTrue($option instanceof Option);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $option = $this->dummyData->getOption();
        $this->assertNotSame($newName, $option->getName());

        $option->setName($newName);
        $this->optionService->edit($option);

        $this->assertSame($newName, $option->getName());
    }

    public function testFind()
    {
        $option1 = $this->dummyData->getOption();
        $this->optionRepository->create($option1);

        $option = $this->optionService->findOneById(1);

        $this->assertTrue($option instanceof Option);
    }

    public function testGetAllOptions()
    {
        $option1 = $this->dummyData->getOption();
        $this->optionRepository->create($option1);

        $options = $this->optionService->getAllOptions();

        $this->assertTrue($options[1] instanceof Option);
    }
}
