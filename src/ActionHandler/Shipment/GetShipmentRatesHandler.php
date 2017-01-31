<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetShipmentRatesQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

final class GetShipmentRatesHandler implements QueryHandlerInterface
{
    /** @var GetShipmentRatesQuery */
    private $query;

    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetShipmentRatesQuery $query,
        ShipmentGatewayInterface $shipmentGateway,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->shipmentGateway = $shipmentGateway;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $request = $this->query->getRequest();
        $response = $this->query->getResponse();

        $shipmentRates = $this->shipmentGateway->getRates(
            $request->getToAddressDTO(),
            $request->getParcelDTO(),
            $request->getFromAddressDTO()
        );

        foreach ($shipmentRates as $shipmentRate) {
            $response->addShipmentRateDTOBuilder(
                $this->dtoBuilderFactory->getShipmentRateDTOBuilder($shipmentRate)
            );
        }
    }
}
