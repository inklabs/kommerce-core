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
    protected $type;

    /** @var DeliveryMethodTypeDTO */
    protected $typeDTO;

    protected function getTypeDTO()
    {
        return new DeliveryMethodTypeDTO;
    }

    protected function preBuild()
    {
        $this->typeDTO->isStandard = $this->type->isStandard();
        $this->typeDTO->isOneDay = $this->type->isOneDay();
        $this->typeDTO->isTwoDay = $this->type->isTwoDay();
    }
}
