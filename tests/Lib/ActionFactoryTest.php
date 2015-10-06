<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Action\Tag\CreateTag;
use inklabs\kommerce\Action\Tag\CreateTagCommand;
use inklabs\kommerce\Action\Tag\DeleteTag;
use inklabs\kommerce\Action\Tag\EditTag;
use inklabs\kommerce\tests\Helper;

class ActionFactoryTest extends Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->setupEntityManager();
    }

    public function testGetInstance()
    {
        $actionFactory = ActionFactory::getInstance($this->repository(), new CartCalculator(new Pricing));
        $this->assertTrue($actionFactory instanceof ActionFactory);
    }

    public function testExecute()
    {
        $actionFactory = $this->actionFactory(new CartCalculator(new Pricing));
        $actionFactory->execute(new CreateTagCommand($this->getDummyTag()));
    }

    public function testGetServices()
    {
        $actionFactory = $this->actionFactory(new CartCalculator(new Pricing));
        $this->assertTrue($actionFactory->getEditTag() instanceof EditTag);
        $this->assertTrue($actionFactory->getCreateTag() instanceof CreateTag);
        $this->assertTrue($actionFactory->getDeleteTag() instanceof DeleteTag);
    }
}
