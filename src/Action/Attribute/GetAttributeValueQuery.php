<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Action\Attribute\Query\GetAttributeValueRequest;
use inklabs\kommerce\Action\Attribute\Query\GetAttributeValueResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetAttributeValueQuery implements QueryInterface
{
    /** @var GetAttributeValueRequest */
    private $request;

    /** @var GetAttributeValueResponseInterface */
    private $response;

    public function __construct(GetAttributeValueRequest $request, GetAttributeValueResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetAttributeValueRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetAttributeValueResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
