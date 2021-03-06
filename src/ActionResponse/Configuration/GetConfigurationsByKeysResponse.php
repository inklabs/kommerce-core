<?php
namespace inklabs\kommerce\ActionResponse\Configuration;

use inklabs\kommerce\EntityDTO\Builder\ConfigurationDTOBuilder;
use inklabs\kommerce\EntityDTO\ConfigurationDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetConfigurationsByKeysResponse implements ResponseInterface
{
    /** @var ConfigurationDTO[] */
    protected $configurationDTOs = [];

    public function addConfigurationDTOBuilder(ConfigurationDTOBuilder $configurationDTOBuilder): void
    {
        $this->configurationDTOs[] = $configurationDTOBuilder->build();
    }

    /**
     * @return ConfigurationDTO[]
     */
    public function getConfigurationDTOs(): array
    {
        return $this->configurationDTOs;
    }
}
