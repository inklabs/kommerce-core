<?php
namespace inklabs\kommerce\Tests\ActionHandler\Product;

use inklabs\kommerce\Action\Product\UnsetDefaultImageForProductCommand;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UnsetDefaultImageForProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $product->setDefaultImage('http://example.com/123.jpg');
        $this->persistEntityAndFlushClear($product);
        $command = new UnsetDefaultImageForProductCommand(
            $product->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $product = $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $product->getId()
        );
        $this->assertNull($product->getDefaultImage());
    }
}
