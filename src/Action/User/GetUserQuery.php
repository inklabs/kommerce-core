<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Action\User\Query\GetUserRequest;
use inklabs\kommerce\Action\User\Query\GetUserResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetUserQuery implements QueryInterface
{
    /** @var GetUserRequest */
    private $request;

    /** @var GetUserResponseInterface */
    private $response;

    public function __construct(GetUserRequest $request, GetUserResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetUserRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetUserResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
