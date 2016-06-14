<?php
namespace inklabs\kommerce\Action\Shipment\Query;

use inklabs\kommerce\EntityDTO\Builder\ShipmentRateDTOBuilder;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;

class GetShipmentRatesResponse implements GetShipmentRatesResponseInterface
{
    /** @var ShipmentRateDTOBuilder[] */
    private $shipmentRateDTOBuilders = [];

    public function addShipmentRateDTOBuilder(ShipmentRateDTOBuilder $shipmentRateDTOBuilder)
    {
        $this->shipmentRateDTOBuilders[] = $shipmentRateDTOBuilder;
    }

    /**
     * @return ShipmentRateDTO[] | \Generator
     */
    public function getShipmentRateDTOs()
    {
        $shipmentRateDTOs = [];
        foreach ($this->shipmentRateDTOBuilders as $shipmentRateDTOBuilder) {
            $shipmentRateDTOs[] = $shipmentRateDTOBuilder->build();
        }
        return $shipmentRateDTOs;
    }
}
