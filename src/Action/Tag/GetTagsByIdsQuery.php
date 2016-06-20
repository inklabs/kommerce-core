<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\Tag\Query\GetTagsByIdsRequest;
use inklabs\kommerce\Action\Tag\Query\GetTagsByIdsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetTagsByIdsQuery implements QueryInterface
{
    /** @var GetTagsByIdsRequest */
    private $request;

    /** @var GetTagsByIdsResponseInterface */
    private $response;

    public function __construct(GetTagsByIdsRequest $request, GetTagsByIdsResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetTagsByIdsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetTagsByIdsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
