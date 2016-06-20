<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Action\Product\Query\GetProductsByIdsRequest;
use inklabs\kommerce\Action\Product\Query\GetProductsByIdsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetProductsByIdsQuery implements QueryInterface
{
    /** @var GetProductsByIdsRequest */
    private $request;

    /** @var GetProductsByIdsResponseInterface */
    private $response;

    public function __construct(GetProductsByIdsRequest $request, GetProductsByIdsResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetProductsByIdsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetProductsByIdsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
