<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageForTagCommand;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateImageForTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
        Image::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $command = new CreateImageForTagCommand(
            $uploadFileDTO,
            $tag->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $tag->getId()
        );
        $this->assertNotEmpty($tag->getImages());
    }
}
