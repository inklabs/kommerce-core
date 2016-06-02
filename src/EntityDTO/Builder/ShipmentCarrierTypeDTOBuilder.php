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
    protected $entity;

    /** @var ShipmentCarrierTypeDTO */
    protected $entityDTO;

    /**
     * @return ShipmentCarrierTypeDTO
     */
    protected function getEntityDTO()
    {
        return new ShipmentCarrierTypeDTO;
    }

    public function __construct(ShipmentCarrierType $type)
    {
        parent::__construct($type);

        $this->entityDTO->isUnknown = $this->entity->isUnknown();
        $this->entityDTO->isUps = $this->entity->isUps();
        $this->entityDTO->isUsps = $this->entity->isUsps();
        $this->entityDTO->isFedex = $this->entity->isFedex();
    }
}
