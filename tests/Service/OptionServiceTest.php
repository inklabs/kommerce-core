<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionRepository;

class OptionServiceTest extends Helper\TestCase\ServiceTestCase
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
        $this->optionRepository->create(new Option);

        $option = $this->optionService->findOneById(1);
        $this->assertTrue($option instanceof Option);
    }

    public function testGetAllOptions()
    {
        $options = $this->optionService->getAllOptions();
        $this->assertTrue($options[0] instanceof Option);
    }
}
