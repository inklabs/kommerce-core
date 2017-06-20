<?php
namespace inklabs\kommerce\ActionResponse\Shipment;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\ShipmentTrackerDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\ShipmentTrackerDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListAdHocShipmentsResponse implements ResponseInterface
{
    /** @var ShipmentTrackerDTOBuilder[] */
    protected $shipmentTrackerDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    protected $paginationDTOBuilder;

    public function addShipmentTrackerDTOBuilder(ShipmentTrackerDTOBuilder $shipmentTrackerDTOBuilder): void
    {
        $this->shipmentTrackerDTOBuilders[] = $shipmentTrackerDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return ShipmentTrackerDTO[]
     */
    public function getShipmentTrackerDTOs(): array
    {
        $shipmentTrackerDTOs = [];
        foreach ($this->shipmentTrackerDTOBuilders as $shipmentTrackerDTOBuilder) {
            $shipmentTrackerDTOs[] = $shipmentTrackerDTOBuilder->build();
        }
        return $shipmentTrackerDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
