<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Action\User\Query\GetUserByEmailRequest;
use inklabs\kommerce\Action\User\Query\GetUserByEmailResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetUserByEmailQuery implements QueryInterface
{
    /** @var GetUserByEmailRequest */
    private $request;

    /** @var GetUserByEmailResponseInterface */
    private $response;

    public function __construct(GetUserByEmailRequest $request, GetUserByEmailResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetUserByEmailRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetUserByEmailResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
