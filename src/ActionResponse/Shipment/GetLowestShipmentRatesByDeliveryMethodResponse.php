<?php
namespace inklabs\kommerce\ActionResponse\Shipment;

use inklabs\kommerce\EntityDTO\Builder\ShipmentRateDTOBuilder;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetLowestShipmentRatesByDeliveryMethodResponse implements ResponseInterface
{
    /** @var ShipmentRateDTOBuilder[] */
    private $shipmentRateDTOBuilders = [];

    public function addShipmentRateDTOBuilder(ShipmentRateDTOBuilder $shipmentRateDTOBuilder): void
    {
        $this->shipmentRateDTOBuilders[] = $shipmentRateDTOBuilder;
    }

    /**
     * @return ShipmentRateDTO[]
     */
    public function getShipmentRateDTOs(): array
    {
        $shipmentRateDTOs = [];
        foreach ($this->shipmentRateDTOBuilders as $shipmentRateDTOBuilder) {
            $shipmentRateDTOs[] = $shipmentRateDTOBuilder->build();
        }
        return $shipmentRateDTOs;
    }
}
