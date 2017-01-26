<?php
namespace inklabs\kommerce\Action\Configuration\Query;

use inklabs\kommerce\EntityDTO\Builder\ConfigurationDTOBuilder;
use inklabs\kommerce\EntityDTO\ConfigurationDTO;

class GetConfigurationsByKeysResponse implements GetConfigurationsByKeysResponseInterface
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
