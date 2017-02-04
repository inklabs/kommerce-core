<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionProductCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateOptionProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionProduct::class,
        Product::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $product = $this->dummyData->getProduct();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product);
        $this->persistEntityAndFlushClear([
            $option,
            $product,
            $optionProduct
        ]);
        $optionProductDTO = $this->getDTOBuilderFactory()
            ->getOptionProductDTOBuilder($optionProduct)
            ->build();
        $sortOrder = 99;
        $optionProductDTO->sortOrder = $sortOrder;
        $command = new UpdateOptionProductCommand($optionProductDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $optionProduct = $this->getRepositoryFactory()->getOptionProductRepository()->findOneById(
            $optionProduct->getId()
        );
        $this->assertSame($sortOrder, $optionProduct->getSortOrder());
    }
}
