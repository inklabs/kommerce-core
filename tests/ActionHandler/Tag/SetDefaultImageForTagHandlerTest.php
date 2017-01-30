<?php
namespace inklabs\kommerce\Tests\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\SetDefaultImageForTagCommand;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetDefaultImageForTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Image::class,
        Tag::class,
        Product::class,
    ];

    public function testHandle()
    {
        $image = $this->dummyData->getImage();
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear([$tag, $image]);
        $command = new SetDefaultImageForTagCommand(
            $tag->getId()->getHex(),
            $image->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $tag->getId()
        );
        $this->assertSame($image->getPath(), $tag->getDefaultImage());
    }
}
