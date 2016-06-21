<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Action\Order\Query\GetOrdersByUserRequest;
use inklabs\kommerce\Action\Order\Query\GetOrdersByUserResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetOrdersByUserQuery implements QueryInterface
{
    /** @var GetOrdersByUserRequest */
    private $request;

    /** @var GetOrdersByUserResponseInterface */
    private $response;

    public function __construct(GetOrdersByUserRequest $request, GetOrdersByUserResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetOrdersByUserRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetOrdersByUserResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
