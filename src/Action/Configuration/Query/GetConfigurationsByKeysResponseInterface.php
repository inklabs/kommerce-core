<?php
namespace inklabs\kommerce\Action\Configuration\Query;

use inklabs\kommerce\EntityDTO\Builder\ConfigurationDTOBuilder;

interface GetConfigurationsByKeysResponseInterface
{
    public function addConfigurationDTOBuilder(ConfigurationDTOBuilder $configurationDTOBuilder);
}
