<?php
namespace inklabs\kommerce\Action\Shipment\Handler;

use inklabs\kommerce\Action\Shipment\GetShipmentRatesRequest;
use inklabs\kommerce\Action\Shipment\Response\GetShipmentRatesResponse;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

class GetShipmentRatesHandler
{
    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    public function __construct(ShipmentGatewayInterface $shipmentGateway)
    {
        $this->shipmentGateway = $shipmentGateway;
    }

    public function handle(GetShipmentRatesRequest $request, GetShipmentRatesResponse & $response)
    {
        $shipmentRates = $this->shipmentGateway->getRates(
            $request->getToAddressDTO(),
            $request->getParcelDTO()
        );

        foreach ($shipmentRates as $shipmentRate) {
            $response->addShipmentRateDTO(
                $shipmentRate->getDTOBuilder()
                    ->build()
            );
        }
    }
}
