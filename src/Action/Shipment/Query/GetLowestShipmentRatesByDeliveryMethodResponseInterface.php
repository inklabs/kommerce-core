<?php
namespace inklabs\kommerce\Action\Shipment\Query;

use inklabs\kommerce\EntityDTO\Builder\ShipmentRateDTOBuilder;

interface GetLowestShipmentRatesByDeliveryMethodResponseInterface
{
    public function addShipmentRateDTOBuilder(ShipmentRateDTOBuilder $shipmentRateDTOBuilder);
}
