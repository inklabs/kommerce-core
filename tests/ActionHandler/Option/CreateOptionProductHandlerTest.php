<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionProductCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOptionProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Option::class,
        OptionProduct::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear([
            $option,
            $product,
        ]);
        $optionProductDTO = $this->getDTOBuilderFactory()
            ->getOptionProductDTOBuilder($this->dummyData->getOptionProduct())
            ->build();
        $command = new CreateOptionProductCommand(
            $option->getId()->getHex(),
            $product->getId()->getHex(),
            $optionProductDTO
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $optionProduct = $this->getRepositoryFactory()->getOptionProductRepository()->findOneById(
            $command->getOptionProductId()
        );
        $this->assertEntitiesEqual($option, $optionProduct->getOption());
        $this->assertEntitiesEqual($product, $optionProduct->getProduct());
        $this->assertSame($optionProductDTO->sortOrder, $optionProduct->getSortOrder());
    }
}
