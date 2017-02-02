<?php
namespace inklabs\kommerce\ActionHandler\Configuration;

use inklabs\kommerce\Action\Configuration\UpdateConfigurationCommand;
use inklabs\kommerce\EntityRepository\ConfigurationRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateConfigurationHandler implements CommandHandlerInterface
{
    /** @var UpdateConfigurationCommand */
    private $command;

    /** @var ConfigurationRepositoryInterface */
    private $configurationRepository;

    public function __construct(
        UpdateConfigurationCommand $command,
        ConfigurationRepositoryInterface $configurationRepository
    ) {
        $this->command = $command;
        $this->configurationRepository = $configurationRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $configuration = $this->configurationRepository->findOneByKey(
            $this->command->getKey()
        );

        $configuration->setValue($this->command->getValue());

        $this->configurationRepository->update($configuration);
    }
}
