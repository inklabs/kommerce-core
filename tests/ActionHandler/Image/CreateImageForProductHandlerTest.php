<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageForProductCommand;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateImageForProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Image::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear($product);
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $command = new CreateImageForProductCommand(
            $uploadFileDTO,
            $product->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $product = $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $product->getId()
        );
        $this->assertNotEmpty($product->getImages());
    }
}
