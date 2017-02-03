<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionProductCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteOptionProductHandlerTest extends ActionTestCase
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
        $command = new DeleteOptionProductCommand($optionProduct->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getOptionProductRepository()->findOneById(
            $optionProduct->getId()
        );
    }
}
