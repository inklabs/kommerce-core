<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\Tag\Query\GetTagRequest;
use inklabs\kommerce\Action\Tag\Query\GetTagResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetTagQuery implements QueryInterface
{
    /** @var GetTagRequest */
    private $request;

    /** @var GetTagResponseInterface */
    private $response;

    public function __construct(GetTagRequest $request, GetTagResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetTagRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetTagResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
