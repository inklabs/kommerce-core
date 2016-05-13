<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Action\Order\Query\GetOrderRequest;
use inklabs\kommerce\Action\Order\Query\GetOrderResponse;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetOrderQuery implements QueryInterface
{
    /** @var GetOrderRequest */
    private $request;

    /** @var \inklabs\kommerce\Action\Order\Query\GetOrderResponse */
    private $response;

    public function __construct(GetOrderRequest $request, GetOrderResponse & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetOrderRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return \inklabs\kommerce\Action\Order\Query\GetOrderResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
