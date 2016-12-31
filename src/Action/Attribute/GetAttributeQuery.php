<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Action\Attribute\Query\GetAttributeRequest;
use inklabs\kommerce\Action\Attribute\Query\GetAttributeResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetAttributeQuery implements QueryInterface
{
    /** @var GetAttributeRequest */
    private $request;

    /** @var GetAttributeResponseInterface */
    private $response;

    public function __construct(GetAttributeRequest $request, GetAttributeResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetAttributeRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetAttributeResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
