<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Action\Product\Query\GetProductsByTagRequest;
use inklabs\kommerce\Action\Product\Query\GetProductsByTagResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetProductsByTagQuery implements QueryInterface
{
    /** @var GetProductsByTagRequest */
    private $request;

    /** @var GetProductsByTagResponseInterface */
    private $response;

    public function __construct(GetProductsByTagRequest $request, GetProductsByTagResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetProductsByTagRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetProductsByTagResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
