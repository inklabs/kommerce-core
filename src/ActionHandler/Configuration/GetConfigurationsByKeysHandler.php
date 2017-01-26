<?php
namespace inklabs\kommerce\ActionHandler\Configuration;

use inklabs\kommerce\Action\Configuration\GetConfigurationsByKeysQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ConfigurationRepositoryInterface;

final class GetConfigurationsByKeysHandler
{
    /** @var ConfigurationRepositoryInterface */
    private $configurationRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ConfigurationRepositoryInterface $configurationRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->dtoBuilderFactory = $dtoBuilderFactory;
        $this->configurationRepository = $configurationRepository;
    }

    public function handle(GetConfigurationsByKeysQuery $query)
    {
        $configurations = $this->configurationRepository->findByKeys(
            $query->getRequest()->getKeys()
        );

        foreach ($configurations as $configuration) {
            $query->getResponse()->addConfigurationDTOBuilder(
                $this->dtoBuilderFactory->getConfigurationDTOBuilder($configuration)
            );
        }
    }
}
