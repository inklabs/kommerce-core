<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetShipmentRatesQuery;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

final class GetShipmentRatesHandler
{
    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    public function __construct(ShipmentGatewayInterface $shipmentGateway)
    {
        $this->shipmentGateway = $shipmentGateway;
    }

    public function handle(GetShipmentRatesQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

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
