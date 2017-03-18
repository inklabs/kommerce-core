<?php
namespace inklabs\kommerce\ActionResponse\Configuration;

use inklabs\kommerce\EntityDTO\Builder\ConfigurationDTOBuilder;
use inklabs\kommerce\EntityDTO\ConfigurationDTO;

class GetConfigurationsByKeysResponse
{
    /** @var ConfigurationDTO[] */
    protected $configurationDTOs = [];

    public function addConfigurationDTOBuilder(ConfigurationDTOBuilder $configurationDTOBuilder)
    {
        $this->configurationDTOs[] = $configurationDTOBuilder->build();
    }

    public function getConfigurationDTOs()
    {
        return $this->configurationDTOs;
    }
}
