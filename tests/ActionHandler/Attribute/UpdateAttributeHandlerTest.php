<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\UpdateAttributeCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateAttributeHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
    ];

    public function testHandle()
    {
        $attribute1 = $this->dummyData->getAttribute();
        $this->persistEntityAndFlushClear($attribute1);
        $name = '50% OFF Everything';
        $sortOrder = 56;
        $description = self::FAKE_TEXT;
        $command = new UpdateAttributeCommand(
            $name,
            $sortOrder,
            $description,
            $attribute1->getId()->toString()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $attribute = $this->getRepositoryFactory()->getAttributeRepository()->findOneById(
            $command->getAttributeId()
        );
        $this->assertSame($name, $attribute->getName());
        $this->assertSame($sortOrder, $attribute->getSortOrder());
        $this->assertSame($description, $attribute->getDescription());
    }
}
