<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteProductAttributeCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteProductAttributeHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
        Product::class,
        ProductAttribute::class,
    ];

    public function testHandle()
    {
        $attribute = $this->dummyData->getAttribute();
        $attributeValue = $this->dummyData->getAttributeValue($attribute);
        $product = $this->dummyData->getProduct();
        $productAttribute = $this->dummyData->getProductAttribute($product, $attributeValue);
        $this->persistEntityAndFlushClear([$attribute, $attributeValue, $product, $productAttribute]);
        $command = new DeleteProductAttributeCommand($productAttribute->getId());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $productAttribute = $this->getRepositoryFactory()->getProductAttributeRepository()->findOneById(
            $command->getProductAttributeId()
        );
    }
}
