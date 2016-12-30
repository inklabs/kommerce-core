<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Action\Attribute\Query\ListAttributesRequest;
use inklabs\kommerce\Action\Attribute\Query\ListAttributesResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class ListAttributesQuery implements QueryInterface
{
    /** @var ListAttributesRequest */
    private $request;

    /** @var ListAttributesResponseInterface */
    private $response;

    public function __construct(ListAttributesRequest $request, ListAttributesResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListAttributesRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListAttributesResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
