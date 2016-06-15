<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Action\Cart\Query\GetCartByUserIdRequest;
use inklabs\kommerce\Action\Cart\Query\GetCartByUserIdResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetCartByUserIdQuery implements QueryInterface
{
    /** @var GetCartByUserIdRequest */
    private $request;

    /** @var GetCartByUserIdResponseInterface */
    private $response;

    public function __construct(GetCartByUserIdRequest $request, GetCartByUserIdResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetCartByUserIdRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetCartByUserIdResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
