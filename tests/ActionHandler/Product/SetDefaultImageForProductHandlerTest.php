<?php
namespace inklabs\kommerce\Tests\ActionHandler\Product;

use inklabs\kommerce\Action\Product\SetDefaultImageForProductCommand;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetDefaultImageForProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Image::class,
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $image = $this->dummyData->getImage();
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear([$product, $image]);
        $command = new SetDefaultImageForProductCommand(
            $product->getId()->getHex(),
            $image->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $product = $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $product->getId()
        );
        $this->assertSame($image->getPath(), $product->getDefaultImage());
    }
}
