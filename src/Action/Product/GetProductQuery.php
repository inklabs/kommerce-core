<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Action\Product\Query\GetProductRequest;
use inklabs\kommerce\Action\Product\Query\GetProductResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetProductQuery implements QueryInterface
{
    /** @var GetProductRequest */
    private $request;

    /** @var GetProductResponseInterface */
    private $response;

    public function __construct(GetProductRequest $request, GetProductResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetProductRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetProductResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
