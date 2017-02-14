<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionType;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateOptionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $this->persistEntityAndFlushClear($option);
        $name = 'new name';
        $description = 'new description';
        $sortOrder = 5;
        $optionTypeSlug = OptionType::checkbox()->getSlug();
        $command = new UpdateOptionCommand(
            $name,
            $description,
            $sortOrder,
            $optionTypeSlug,
            $option->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $option = $this->getRepositoryFactory()->getOptionRepository()->findOneById(
            $option->getId()
        );
        $this->assertSame($name, $option->getName());
        $this->assertSame($description, $option->getDescription());
        $this->assertSame($sortOrder, $option->getSortOrder());
        $this->assertSame($optionTypeSlug, $option->getType()->getSlug());
    }
}
