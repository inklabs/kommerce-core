<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Action\Option\Query\GetOptionRequest;
use inklabs\kommerce\Action\Option\Query\GetOptionResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetOptionQuery implements QueryInterface
{
    /** @var GetOptionRequest */
    private $request;

    /** @var GetOptionResponseInterface */
    private $response;

    public function __construct(GetOptionRequest $request, GetOptionResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetOptionRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetOptionResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
