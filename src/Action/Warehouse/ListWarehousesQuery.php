<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Action\Warehouse\Query\ListWarehousesRequest;
use inklabs\kommerce\Action\Warehouse\Query\ListWarehousesResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class ListWarehousesQuery implements QueryInterface
{
    /** @var ListWarehousesRequest */
    private $request;

    /** @var ListWarehousesResponseInterface */
    private $response;

    public function __construct(ListWarehousesRequest $request, ListWarehousesResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListWarehousesRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListWarehousesResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
