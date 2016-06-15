<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Action\Cart\Query\GetCartRequest;
use inklabs\kommerce\Action\Cart\Query\GetCartResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetCartQuery implements QueryInterface
{
    /** @var GetCartRequest */
    private $request;

    /** @var GetCartResponseInterface */
    private $response;

    public function __construct(GetCartRequest $request, GetCartResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetCartRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetCartResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
