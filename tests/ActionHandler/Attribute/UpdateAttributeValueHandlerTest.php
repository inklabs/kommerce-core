<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\UpdateAttributeValueCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateAttributeValueHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
    ];

    public function testHandle()
    {
        $attribute = $this->dummyData->getAttribute();
        $attributeValue = $this->dummyData->getAttributeValue($attribute);
        $this->persistEntityAndFlushClear([$attribute, $attributeValue]);
        $name = '50% OFF Everything';
        $sortOrder = 12;
        $sku = self::FAKE_SKU;
        $description = self::FAKE_TEXT;
        $command = new UpdateAttributeValueCommand(
            $name,
            $sortOrder,
            $sku,
            $description,
            $attributeValue->getId()->getHex()
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
