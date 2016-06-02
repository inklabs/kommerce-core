<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\DeliveryMethodType;
use inklabs\kommerce\EntityDTO\DeliveryMethodTypeDTO;

/**
 * @method DeliveryMethodTypeDTO build()
 */
class DeliveryMethodTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var DeliveryMethodType */
    protected $entity;

    /** @var DeliveryMethodTypeDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new DeliveryMethodTypeDTO;
    }

    protected function preBuild()
    {
        $this->entityDTO->isStandard = $this->entity->isStandard();
        $this->entityDTO->isOneDay = $this->entity->isOneDay();
        $this->entityDTO->isTwoDay = $this->entity->isTwoDay();
    }
}
