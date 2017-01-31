<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\AddTagToProductCommand;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddTagToProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear([$tag, $product]);
        $command = new AddTagToProductCommand(
            $product->getId()->getHex(),
            $tag->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $product = $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $product->getId()
        );
        $this->assertEntitiesEqual($tag, $product->getTags()[0]);
    }
}
