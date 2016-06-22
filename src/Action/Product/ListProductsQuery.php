<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Action\Product\Query\ListProductsRequest;
use inklabs\kommerce\Action\Product\Query\ListProductsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class ListProductsQuery implements QueryInterface
{
    /** @var ListProductsRequest */
    private $request;

    /** @var ListProductsResponseInterface */
    private $response;

    public function __construct(ListProductsRequest $request, ListProductsResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListProductsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListProductsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
