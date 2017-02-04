<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionCommand;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateOptionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $this->persistEntityAndFlushClear($option);
        $optionDTO = $this->getDTOBuilderFactory()
            ->getOptionDTOBuilder($option)
            ->build();
        $name = 'new name';
        $optionDTO->name = $name;
        $command = new UpdateOptionCommand($optionDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $option = $this->getRepositoryFactory()->getOptionRepository()->findOneById(
            $option->getId()
        );
        $this->assertSame($name, $option->getName());
    }
}
