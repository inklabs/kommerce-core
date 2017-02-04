<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionValueCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateOptionValueHandlerTest extends ActionTestCase
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
        $optionValueDTO = $this->getDTOBuilderFactory()
            ->getOptionValueDTOBuilder($optionValue)
            ->build();
        $name = 'new name';
        $optionValueDTO->name = $name;
        $command = new UpdateOptionValueCommand($optionValueDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $optionValue = $this->getRepositoryFactory()->getOptionValueRepository()->findOneById(
            $optionValue->getId()
        );
        $this->assertSame($name, $optionValue->getName());
    }
}
