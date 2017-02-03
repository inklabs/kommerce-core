<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteOptionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $this->persistEntityAndFlushClear($option);
        $command = new DeleteOptionCommand($option->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getOptionRepository()->findOneById(
            $option->getId()
        );
    }
}
