<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\Tag\Query\ListTagsResponse;
use inklabs\kommerce\Lib\Query\QueryInterface;

class ListTagsQuery implements QueryInterface
{
    /** @var ListTagsRequest */
    private $request;

    /** @var ListTagsResponse */
    private $response;

    public function __construct(ListTagsRequest $request, ListTagsResponse $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListTagsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListTagsResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
