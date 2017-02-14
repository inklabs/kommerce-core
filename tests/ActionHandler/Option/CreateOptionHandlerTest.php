<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionType;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOptionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        Product::class,
    ];

    public function testHandle()
    {
        $name = 'new name';
        $description = 'new description';
        $sortOrder = 5;
        $optionTypeSlug = OptionType::checkbox()->getSlug();
        $command = new CreateOptionCommand(
            $name,
            $description,
            $sortOrder,
            $optionTypeSlug
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $option = $this->getRepositoryFactory()->getOptionRepository()->findOneById(
            $command->getOptionId()
        );
        $this->assertSame($name, $option->getName());
        $this->assertSame($description, $option->getDescription());
        $this->assertSame($sortOrder, $option->getSortOrder());
        $this->assertSame($optionTypeSlug, $option->getType()->getSlug());
    }
}
