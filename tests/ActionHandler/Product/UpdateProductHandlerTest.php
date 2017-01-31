<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\UpdateProductCommand;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear($product);
        $productDTO = $this->getDTOBuilderFactory()
            ->getProductDTOBuilder($product)
            ->build();
        $productDTO->name = 'new name';
        $command = new UpdateProductCommand($productDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $product = $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $product->getId()
        );
        $this->assertSame($productDTO->name, $product->getName());
    }
}
