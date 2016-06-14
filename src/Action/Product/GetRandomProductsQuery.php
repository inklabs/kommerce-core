<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Action\Product\Query\GetRandomProductsRequest;
use inklabs\kommerce\Action\Product\Query\GetRandomProductsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetRandomProductsQuery implements QueryInterface
{
    /** @var GetRandomProductsRequest */
    private $request;

    /** @var GetRandomProductsResponseInterface */
    private $response;

    public function __construct(GetRandomProductsRequest $request, GetRandomProductsResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetRandomProductsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetRandomProductsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
