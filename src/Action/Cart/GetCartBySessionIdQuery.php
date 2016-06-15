<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Action\Cart\Query\GetCartBySessionIdRequest;
use inklabs\kommerce\Action\Cart\Query\GetCartBySessionIdResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetCartBySessionIdQuery implements QueryInterface
{
    /** @var GetCartBySessionIdRequest */
    private $request;

    /** @var GetCartBySessionIdResponseInterface */
    private $response;

    public function __construct(GetCartBySessionIdRequest $request, GetCartBySessionIdResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetCartBySessionIdRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetCartBySessionIdResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
