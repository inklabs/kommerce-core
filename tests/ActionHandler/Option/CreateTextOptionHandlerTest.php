<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateTextOptionCommand;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateTextOptionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        TextOption::class,
    ];

    public function testHandle()
    {
        $name = 'John Doe';
        $description = 'Test Description';
        $sortOrder = 1;
        $command = new CreateTextOptionCommand(
            $name,
            $description,
            $sortOrder,
            $this->dummyData->getTextOptionType()->getId()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $textOption = $this->getRepositoryFactory()->getTextOptionRepository()->findOneById(
            $command->getTextOptionId()
        );
        $this->assertSame($name, $textOption->getName());
        $this->assertSame($description, $textOption->getDescription());
        $this->assertSame($sortOrder, $textOption->getSortOrder());
    }
}
