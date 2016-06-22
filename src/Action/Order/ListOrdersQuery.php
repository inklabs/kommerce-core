<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Action\Order\Query\ListOrdersRequest;
use inklabs\kommerce\Action\Order\Query\ListOrdersResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class ListOrdersQuery implements QueryInterface
{
    /** @var ListOrdersRequest */
    private $request;

    /** @var ListOrdersResponseInterface */
    private $response;

    public function __construct(ListOrdersRequest $request, ListOrdersResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListOrdersRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListOrdersResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
