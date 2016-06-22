<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Action\Option\Query\ListOptionsRequest;
use inklabs\kommerce\Action\Option\Query\ListOptionsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class ListOptionsQuery implements QueryInterface
{
    /** @var ListOptionsRequest */
    private $request;

    /** @var ListOptionsResponseInterface */
    private $response;

    public function __construct(ListOptionsRequest $request, ListOptionsResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListOptionsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListOptionsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
