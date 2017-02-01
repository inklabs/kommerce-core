<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\RemoveTagFromProductCommand;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveTagFromProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $product = $this->dummyData->getProduct();
        $product->addTag($tag);
        $this->persistEntityAndFlushClear([
            $product,
            $tag,
        ]);
        $command = new RemoveTagFromProductCommand(
            $product->getId()->getHex(),
            $tag->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $product = $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $product->getId()
        );
        $this->assertEmpty($product->getTags());
    }
}
