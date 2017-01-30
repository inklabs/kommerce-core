<?php
namespace inklabs\kommerce\Tests\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\UnsetDefaultImageForTagCommand;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UnsetDefaultImageForTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Image::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $image = $this->dummyData->getImage();
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear([$tag, $image]);
        $command = new UnsetDefaultImageForTagCommand(
            $tag->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $tag->getId()
        );
        $this->assertNull($tag->getDefaultImage());
    }
}
