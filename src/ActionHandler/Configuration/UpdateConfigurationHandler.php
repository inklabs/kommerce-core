<?php
namespace inklabs\kommerce\ActionHandler\Configuration;

use inklabs\kommerce\Action\Configuration\UpdateConfigurationCommand;
use inklabs\kommerce\EntityRepository\ConfigurationRepositoryInterface;

final class UpdateConfigurationHandler
{
    /** @var ConfigurationRepositoryInterface */
    private $configurationRepository;

    public function __construct(ConfigurationRepositoryInterface $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function handle(UpdateConfigurationCommand $command)
    {
        $configuration = $this->configurationRepository->findOneByKey(
            $command->getKey()
        );

        $configuration->setValue($command->getValue());

        $this->configurationRepository->update($configuration);
    }
}
