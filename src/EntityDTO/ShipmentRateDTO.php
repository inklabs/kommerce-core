<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class ShipmentRateDTO
{
    /** @var MoneyDTO */
    public $rate;

    /** @var MoneyDTO */
    public $listRate;

    /** @var MoneyDTO */
    public $retailRate;

    /** @var string */
    public $externalId;

    /** @var string */
    public $shipmentExternalId;

    /** @var string */
    public $service;

    /** @var string */
    public $carrier;

    /** @var DateTime */
    public $deliveryDate;

    /** @var boolean */
    public $isDeliveryDateGuaranteed;

    /** @var int */
    public $deliveryDays;

    /** @var int */
    public $estDeliveryDays;

    /** @var DeliveryMethodTypeDTO */
    public $deliveryMethod;
}
