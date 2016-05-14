<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Action\Shipment\Query\GetShipmentRatesRequest;
use inklabs\kommerce\Action\Shipment\Query\GetShipmentRatesResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetShipmentRatesQuery implements QueryInterface
{
    /** @var GetShipmentRatesRequest */
    private $request;

    /** @var GetShipmentRatesResponseInterface */
    private $response;

    public function __construct(GetShipmentRatesRequest $request, GetShipmentRatesResponseInterface & $response)
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
     * @return GetShipmentRatesResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
