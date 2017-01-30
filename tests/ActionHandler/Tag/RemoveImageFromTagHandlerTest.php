<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\RemoveImageFromTagCommand;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveImageFromTagHandlerTest extends ActionTestCase
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
        $tag->addImage($image);
        $this->persistEntityAndFlushClear([$tag, $image]);
        $command = new RemoveImageFromTagCommand(
            $tag->getId()->getHex(),
            $image->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $tag->getId()
        );
        $this->assertEmpty($tag->getImages());
    }
}
