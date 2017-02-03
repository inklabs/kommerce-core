<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionValueCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOptionValueHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionValue::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $this->persistEntityAndFlushClear($option);
        $optionValueDTO = $this->getDTOBuilderFactory()
            ->getOptionValueDTOBuilder($this->dummyData->getOptionValue())
            ->build();
        $command = new CreateOptionValueCommand(
            $option->getId()->getHex(),
            $optionValueDTO
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $optionValue = $this->getRepositoryFactory()->getOptionValueRepository()->findOneById(
            $command->getOptionValueId()
        );
        $this->assertSame($optionValueDTO->name, $optionValue->getName());
        // TODO: Test all attributes
    }
}
