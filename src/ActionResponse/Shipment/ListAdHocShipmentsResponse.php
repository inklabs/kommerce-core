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

    public function addShipmentTrackerDTOBuilder(ShipmentTrackerDTOBuilder $shipmentTrackerDTOBuilder)
    {
        $this->shipmentTrackerDTOBuilders[] = $shipmentTrackerDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return ShipmentTrackerDTO[]
     */
    public function getShipmentTrackerDTOs()
    {
        $shipmentTrackerDTOs = [];
        foreach ($this->shipmentTrackerDTOBuilders as $shipmentTrackerDTOBuilder) {
            $shipmentTrackerDTOs[] = $shipmentTrackerDTOBuilder->build();
        }
        return $shipmentTrackerDTOs;
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
