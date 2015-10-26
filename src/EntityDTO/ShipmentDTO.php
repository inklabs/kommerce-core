<?php
namespace inklabs\kommerce\EntityDTO;

class ShipmentDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var ShipmentTrackerDTO[] */
    public $shipmentTrackers = [];

    /** @var ShipmentItemDTO[] */
    public $shipmentItems = [];

    /** @var ShipmentCommentDTO[] */
    public $shipmentComments = [];

    /** @var OrderDTO */
    public $order;
}
