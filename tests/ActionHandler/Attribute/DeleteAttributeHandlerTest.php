<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteAttributeCommand;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteAttributeHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
    ];

    public function testHandle()
    {
        $attribute = $this->dummyData->getAttribute();
        $this->persistEntityAndFlushClear($attribute);
        $command = new DeleteAttributeCommand($attribute->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getAttributeRepository()->findOneById(
            $command->getAttributeId()
        );
    }
}
