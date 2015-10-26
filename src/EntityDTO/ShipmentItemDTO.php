<?php
namespace inklabs\kommerce\EntityDTO;

class ShipmentItemDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var OrderItemDTO */
    public $orderItem;

    /** @var int */
    public $quantityToShip;
}
