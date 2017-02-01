<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\RemoveImageFromProductCommand;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveImageFromProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
        Image::class,
    ];

    public function testHandle()
    {
        $image = $this->dummyData->getImage();
        $product = $this->dummyData->getProduct();
        $product->addImage($image);
        $this->persistEntityAndFlushClear([
            $product,
            $image,
        ]);
        $command = new RemoveImageFromProductCommand(
            $product->getId()->getHex(),
            $image->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $product = $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $product->getId()
        );
        $this->assertEmpty($product->getImages());
    }
}
