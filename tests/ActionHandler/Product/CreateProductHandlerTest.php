<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\CreateProductCommand;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
    ];

    public function testHandle()
    {
        $productDTO = $this->getDTOBuilderFactory()
            ->getProductDTOBuilder($this->dummyData->getProduct())
            ->build();
        $command = new CreateProductCommand($productDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $product = $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $command->getProductId()
        );
        $this->assertSame($productDTO->name, $product->getName());
    }
}
