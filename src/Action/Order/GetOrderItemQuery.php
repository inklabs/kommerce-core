<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Action\Order\Query\GetOrderItemRequest;
use inklabs\kommerce\Action\Order\Query\GetOrderItemResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetOrderItemQuery implements QueryInterface
{
    /** @var GetOrderItemRequest */
    private $request;

    /** @var GetOrderItemResponseInterface */
    private $response;

    public function __construct(GetOrderItemRequest $request, GetOrderItemResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetOrderItemRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetOrderItemResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
