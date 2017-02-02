<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteAttributeValueCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteAttributeValueHandlerTest extends ActionTestCase
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
        $command = new DeleteAttributeValueCommand($attributeValue->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getAttributeValueRepository()->findOneById(
            $command->getAttributeValueId()
        );
    }
}
