<?php
namespace inklabs\kommerce\Action\Shipment\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\ShipmentTrackerDTOBuilder;

interface ListAdHocShipmentsResponseInterface
{
    public function addShipmentTrackerDTOBuilder(ShipmentTrackerDTOBuilder $shipmentTrackerDTOBuilder);
    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder);
}
