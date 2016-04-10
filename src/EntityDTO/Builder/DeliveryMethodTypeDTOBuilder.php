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

    /**
     * @return DeliveryMethodTypeDTO
     */
    protected function getTypeDTO()
    {
        return new DeliveryMethodTypeDTO;
    }

    public function __construct(DeliveryMethodType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isStandard = $this->type->isStandard();
        $this->typeDTO->isOneDay = $this->type->isOneDay();
        $this->typeDTO->isTwoDay = $this->type->isTwoDay();
    }
}
