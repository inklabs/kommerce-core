<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\Tag\Query\ListTagsRequest;
use inklabs\kommerce\Action\Tag\Query\ListTagsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class ListTagsQuery implements QueryInterface
{
    /** @var ListTagsRequest */
    private $request;

    /** @var ListTagsResponseInterface */
    private $response;

    public function __construct(ListTagsRequest $request, ListTagsResponseInterface & $response)
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
     * @return ListTagsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
