<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Action\Product\Query\GetRelatedProductsRequest;
use inklabs\kommerce\Action\Product\Query\GetRelatedProductsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetRelatedProductsQuery implements QueryInterface
{
    /** @var GetRelatedProductsRequest */
    private $request;

    /** @var GetRelatedProductsResponseInterface */
    private $response;

    public function __construct(GetRelatedProductsRequest $request, GetRelatedProductsResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetRelatedProductsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetRelatedProductsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
