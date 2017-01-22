<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateAttributeCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeChoiceType;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateAttributeHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
    ];

    public function testHandle()
    {
        $name = '50% OFF Everything';
        $choiceType = AttributeChoiceType::imageLink()->getSlug();
        $sortOrder = 12;
        $description = self::FAKE_TEXT;
        $command = new CreateAttributeCommand(
            $name,
            $choiceType,
            $sortOrder,
            $description
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $attribute = $this->getRepositoryFactory()->getAttributeRepository()->findOneById(
            $command->getAttributeId()
        );
        $this->assertSame($name, $attribute->getName());
        $this->assertTrue($attribute->getChoiceType()->isImageLink());
        $this->assertSame($sortOrder, $attribute->getSortOrder());
        $this->assertSame($description, $attribute->getDescription());
    }
}
