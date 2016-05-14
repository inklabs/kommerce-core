<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Action\Order\Query\CreateOrderFromCartRequest;
use inklabs\kommerce\Action\Order\Query\CreateOrderFromCartResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class CreateOrderFromCartQuery implements QueryInterface
{
    /** @var CreateOrderFromCartRequest */
    private $request;

    /** @var CreateOrderFromCartResponseInterface */
    private $response;

    public function __construct(CreateOrderFromCartRequest $request, CreateOrderFromCartResponseInterface & $response)
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
     * @return CreateOrderFromCartResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
