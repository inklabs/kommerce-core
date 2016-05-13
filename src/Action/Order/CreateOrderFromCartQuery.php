<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Action\Order\Query\CreateOrderFromCartRequest;
use inklabs\kommerce\Action\Order\Query\CreateOrderFromCartResponse;
use inklabs\kommerce\Lib\Query\QueryInterface;

class CreateOrderFromCartQuery implements QueryInterface
{
    /** @var CreateOrderFromCartRequest */
    private $request;

    /** @var \inklabs\kommerce\Action\Order\Query\CreateOrderFromCartResponse */
    private $response;

    public function __construct(CreateOrderFromCartRequest $request, CreateOrderFromCartResponse & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return CreateOrderFromCartRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return \inklabs\kommerce\Action\Order\Query\CreateOrderFromCartResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
