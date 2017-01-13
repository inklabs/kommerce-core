<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Action\Shipment\Query\ListAdHocShipmentsRequest;
use inklabs\kommerce\Action\Shipment\Query\ListAdHocShipmentsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class ListAdHocShipmentsQuery implements QueryInterface
{
    /** @var ListAdHocShipmentsRequest */
    private $request;

    /** @var ListAdHocShipmentsResponseInterface */
    private $response;

    public function __construct(ListAdHocShipmentsRequest $request, ListAdHocShipmentsResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListAdHocShipmentsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListAdHocShipmentsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
