<?php
namespace inklabs\kommerce\EntityDTO;

class DeliveryMethodTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isStandard;

    /** @var bool */
    public $isOneDay;

    /** @var bool */
    public $isTwoDay;
}
