<?php
namespace inklabs\kommerce\EntityDTO;

class ShipmentCarrierTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isUnknown;

    /** @var bool */
    public $isUps;

    /** @var bool */
    public $isUsps;

    /** @var bool */
    public $isFedex;
}
