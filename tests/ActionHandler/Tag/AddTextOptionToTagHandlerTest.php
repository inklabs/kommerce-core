<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\AddTextOptionToTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddTextOptionToTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Tag::class,
        TextOption::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $textOption = $this->dummyData->getTextOption();
        $this->persistEntityAndFlushClear([$tag, $textOption]);
        $command = new AddTextOptionToTagCommand(
            $tag->getId()->getHex(),
            $textOption->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $command->getTagId()
        );
        $this->assertEntitiesEqual($textOption, $tag->getTextOptions()[0]);
    }
}
