<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOptionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        Product::class,
    ];

    public function testHandle()
    {
        $optionDTO = $this->getDTOBuilderFactory()
            ->getOptionDTOBuilder($this->dummyData->getOption())
            ->build();
        $command = new CreateOptionCommand($optionDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $option = $this->getRepositoryFactory()->getOptionRepository()->findOneById(
            $command->getOptionId()
        );
        $this->assertSame($optionDTO->name, $option->getName());
        // TODO: Test more attributes
    }
}
