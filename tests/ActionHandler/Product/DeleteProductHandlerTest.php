<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\DeleteProductCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
        Product::class,
        ProductQuantityDiscount::class,
        ProductAttribute::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear($product);
        $command = new DeleteProductCommand($product->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();

        $this->setExpectedException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getProductRepository()->findOneById(
            $product->getId()
        );
    }
}
