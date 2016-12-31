<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateAttributeCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateAttributeHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
    ];

    public function testHandle()
    {
        $name = '50% OFF Everything';
        $sortOrder = 12;
        $description = self::FAKE_TEXT;
        $command = new CreateAttributeCommand(
            $name,
            $sortOrder,
            $description
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $coupon = $this->getRepositoryFactory()->getAttributeRepository()->findOneById(
            $command->getAttributeId()
        );
        $this->assertSame($name, $coupon->getName());
        $this->assertSame($sortOrder, $coupon->getSortOrder());
        $this->assertSame($description, $coupon->getDescription());
    }
}
