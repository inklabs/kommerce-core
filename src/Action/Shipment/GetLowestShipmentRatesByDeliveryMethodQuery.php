<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Action\Shipment\Query\GetLowestShipmentRatesByDeliveryMethodRequest;
use inklabs\kommerce\Action\Shipment\Query\GetLowestShipmentRatesByDeliveryMethodResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetLowestShipmentRatesByDeliveryMethodQuery implements QueryInterface
{
    /** @var GetLowestShipmentRatesByDeliveryMethodRequest */
    private $request;

    /** @var GetLowestShipmentRatesByDeliveryMethodResponseInterface */
    private $response;

    public function __construct(
        GetLowestShipmentRatesByDeliveryMethodRequest $request,
        GetLowestShipmentRatesByDeliveryMethodResponseInterface & $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetLowestShipmentRatesByDeliveryMethodRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetLowestShipmentRatesByDeliveryMethodResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
