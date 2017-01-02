<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateProductAttributeCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateProductAttributeHandlerTest extends ActionTestCase
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
        $this->persistEntityAndFlushClear([$attribute, $attributeValue, $product]);
        $command = new CreateProductAttributeCommand(
            $attributeValue->getId(),
            $product->getId()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $productAttribute = $this->getRepositoryFactory()->getProductAttributeRepository()->findOneById(
            $command->getProductAttributeId()
        );
        $this->assertEntitiesEqual($attributeValue, $productAttribute->getAttributeValue());
        $this->assertEntitiesEqual($product, $productAttribute->getProduct());
    }
}
