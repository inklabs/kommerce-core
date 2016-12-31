<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateAttributeValueCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateAttributeValueHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
    ];

    public function testHandle()
    {
        $attribute = $this->dummyData->getAttribute();
        $this->persistEntityAndFlushClear($attribute);
        $name = '50% OFF Everything';
        $sortOrder = 12;
        $sku = self::FAKE_SKU;
        $description = self::FAKE_TEXT;
        $command = new CreateAttributeValueCommand(
            $name,
            $sortOrder,
            $sku,
            $description,
            $attribute->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $attributeValue = $this->getRepositoryFactory()->getAttributeValueRepository()->findOneById(
            $command->getAttributeValueId()
        );
        $this->assertSame($name, $attributeValue->getName());
        $this->assertSame($sortOrder, $attributeValue->getSortOrder());
        $this->assertSame($sku, $attributeValue->getSku());
        $this->assertSame($description, $attributeValue->getDescription());
        $this->assertEntitiesEqual($attribute, $attributeValue->getAttribute());
    }
}
