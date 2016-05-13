<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Action\User\Query\LoginWithTokenRequest;
use inklabs\kommerce\Action\User\Query\LoginWithTokenResponse;
use inklabs\kommerce\Lib\Query\QueryInterface;

class LoginWithTokenQuery implements QueryInterface
{
    /** @var LoginWithTokenRequest */
    private $request;

    /** @var \inklabs\kommerce\Action\User\Query\LoginWithTokenResponse */
    private $response;

    public function __construct(LoginWithTokenRequest $request, LoginWithTokenResponse & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return LoginWithTokenRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return \inklabs\kommerce\Action\User\Query\LoginWithTokenResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
