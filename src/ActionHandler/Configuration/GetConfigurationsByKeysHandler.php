<?php
namespace inklabs\kommerce\ActionHandler\Configuration;

use inklabs\kommerce\Action\Configuration\GetConfigurationsByKeysQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ConfigurationRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetConfigurationsByKeysHandler implements QueryHandlerInterface
{
    /** @var GetConfigurationsByKeysQuery */
    private $query;

    /** @var ConfigurationRepositoryInterface */
    private $configurationRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetConfigurationsByKeysQuery $query,
        ConfigurationRepositoryInterface $configurationRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
        $this->configurationRepository = $configurationRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $configurations = $this->configurationRepository->findByKeys(
            $this->query->getRequest()->getKeys()
        );

        foreach ($configurations as $configuration) {
            $this->query->getResponse()->addConfigurationDTOBuilder(
                $this->dtoBuilderFactory->getConfigurationDTOBuilder($configuration)
            );
        }
    }
}
