<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Action\Order\Query\GetOrderRequest;
use inklabs\kommerce\Action\Order\Query\GetOrderResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetOrderQuery implements QueryInterface
{
    /** @var GetOrderRequest */
    private $request;

    /** @var GetOrderResponseInterface */
    private $response;

    public function __construct(GetOrderRequest $request, GetOrderResponseInterface & $response)
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
     * @return GetOrderResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
