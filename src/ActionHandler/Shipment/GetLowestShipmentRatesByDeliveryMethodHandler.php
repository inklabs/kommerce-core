<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetLowestShipmentRatesByDeliveryMethodQuery;
use inklabs\kommerce\ActionResponse\Shipment\GetLowestShipmentRatesByDeliveryMethodResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

final class GetLowestShipmentRatesByDeliveryMethodHandler implements QueryHandlerInterface
{
    /** @var GetLowestShipmentRatesByDeliveryMethodQuery */
    private $query;

    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetLowestShipmentRatesByDeliveryMethodQuery $query,
        ShipmentGatewayInterface $shipmentGateway,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->shipmentGateway = $shipmentGateway;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $response = new GetLowestShipmentRatesByDeliveryMethodResponse();

        $shipmentRates = $this->shipmentGateway->getTrimmedRates(
            $this->query->getToAddressDTO(),
            $this->query->getParcelDTO()
        );

        foreach ($shipmentRates as $shipmentRate) {
            $response->addShipmentRateDTOBuilder(
                $this->dtoBuilderFactory->getShipmentRateDTOBuilder($shipmentRate)
            );
        }

        return $response;
    }
}
