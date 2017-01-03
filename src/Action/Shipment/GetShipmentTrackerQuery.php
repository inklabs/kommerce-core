<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Action\Shipment\Query\GetShipmentTrackerRequest;
use inklabs\kommerce\Action\Shipment\Query\GetShipmentTrackerResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetShipmentTrackerQuery implements QueryInterface
{
    /** @var GetShipmentTrackerRequest */
    private $request;

    /** @var GetShipmentTrackerResponseInterface */
    private $response;

    public function __construct(GetShipmentTrackerRequest $request, GetShipmentTrackerResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetShipmentTrackerRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetShipmentTrackerResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
