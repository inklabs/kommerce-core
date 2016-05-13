<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Action\Shipment\Query\GetShipmentRatesRequest;
use inklabs\kommerce\Action\Shipment\Query\GetShipmentRatesResponse;

class GetShipmentRatesQuery
{
    /** @var GetShipmentRatesRequest */
    private $request;

    /** @var GetShipmentRatesResponse */
    private $response;

    public function __construct(GetShipmentRatesRequest $request, GetShipmentRatesResponse & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetShipmentRatesRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetShipmentRatesResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
