<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionValueCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteOptionValueHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionValue::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $optionValue = $this->dummyData->getOptionValue($option);
        $this->persistEntityAndFlushClear([
            $option,
            $optionValue,
        ]);
        $command = new DeleteOptionValueCommand($optionValue->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getOptionValueRepository()->findOneById(
            $optionValue->getId()
        );
    }
}
