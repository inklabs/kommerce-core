<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Configuration;
use inklabs\kommerce\EntityDTO\ConfigurationDTO;

class ConfigurationDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Configuration */
    protected $entity;

    /** @var ConfigurationDTO */
    protected $entityDTO;

    public function __construct(Configuration $configuration)
    {
        $this->entity = $configuration;

        $this->initializeConfigurationDTO();
        $this->setId();
        $this->setTime();
        $this->entityDTO->key   = $this->entity->getKey();
        $this->entityDTO->name  = $this->entity->getName();
        $this->entityDTO->value = $this->entity->getValue();
    }

    protected function initializeConfigurationDTO()
    {
        $this->entityDTO = new ConfigurationDTO();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
