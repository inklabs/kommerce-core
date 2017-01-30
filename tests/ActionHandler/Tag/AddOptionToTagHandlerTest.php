<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\AddOptionToTagCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddOptionToTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Tag::class,
        Option::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $option = $this->dummyData->getOption();
        $this->persistEntityAndFlushClear([$tag, $option]);
        $command = new AddOptionToTagCommand(
            $tag->getId()->getHex(),
            $option->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $command->getTagId()
        );
        $this->assertEntitiesEqual($option, $tag->getOptions()[0]);
    }
}
