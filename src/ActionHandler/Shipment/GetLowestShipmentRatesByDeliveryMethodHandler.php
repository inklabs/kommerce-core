<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetLowestShipmentRatesByDeliveryMethodQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

final class GetLowestShipmentRatesByDeliveryMethodHandler
{
    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ShipmentGatewayInterface $shipmentGateway,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->shipmentGateway = $shipmentGateway;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetLowestShipmentRatesByDeliveryMethodQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

        $shipmentRates = $this->shipmentGateway->getTrimmedRates(
            $request->getToAddressDTO(),
            $request->getParcelDTO()
        );

        foreach ($shipmentRates as $shipmentRate) {
            $response->addShipmentRateDTOBuilder(
                $this->dtoBuilderFactory->getShipmentRateDTOBuilder($shipmentRate)
            );
        }
    }
}
