<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentCarrierType;
use inklabs\kommerce\EntityDTO\ShipmentCarrierTypeDTO;

/**
 * @method ShipmentCarrierTypeDTO build()
 */
class ShipmentCarrierTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var ShipmentCarrierType */
    protected $type;

    /** @var ShipmentCarrierTypeDTO */
    protected $typeDTO;

    /**
     * @return ShipmentCarrierTypeDTO
     */
    protected function getTypeDTO()
    {
        return new ShipmentCarrierTypeDTO;
    }

    public function __construct(ShipmentCarrierType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isUnknown = $this->type->isUnknown();
        $this->typeDTO->isUps = $this->type->isUps();
        $this->typeDTO->isUsps = $this->type->isUsps();
        $this->typeDTO->isFedex = $this->type->isFedex();
    }
}
