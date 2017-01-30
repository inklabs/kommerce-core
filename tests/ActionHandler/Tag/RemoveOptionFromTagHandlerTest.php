<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\RemoveOptionFromTagCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveOptionFromTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Tag::class,
        Option::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $tag = $this->dummyData->getTag();
        $tag->addOption($option);
        $this->persistEntityAndFlushClear([$tag, $option]);
        $command = new RemoveOptionFromTagCommand(
            $tag->getId()->getHex(),
            $option->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $tag->getId()
        );
        $this->assertEmpty($tag->getOptions());
    }
}
