<?php
namespace inklabs\kommerce\ActionHandler\Configuration;

use inklabs\kommerce\Action\Configuration\UpdateConfigurationCommand;
use inklabs\kommerce\Entity\Configuration;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateConfigurationHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Configuration::class,
    ];

    public function testHandle()
    {
        $configuration = $this->dummyData->getConfiguration();
        $this->persistEntityAndFlushClear($configuration);
        $key = 'storeTheme';
        $value = 'foundation';
        $command = new UpdateConfigurationCommand(
            $key,
            $value
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $configuration = $this->getRepositoryFactory()
            ->getConfigurationRepository()
            ->findOneByKey($key);
        $this->assertSame($value, $configuration->getValue());
    }
}
