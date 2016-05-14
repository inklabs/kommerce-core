<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Action\User\Query\LoginWithTokenRequest;
use inklabs\kommerce\Action\User\Query\LoginWithTokenResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class LoginWithTokenQuery implements QueryInterface
{
    /** @var LoginWithTokenRequest */
    private $request;

    /** @var LoginWithTokenResponseInterface */
    private $response;

    public function __construct(LoginWithTokenRequest $request, LoginWithTokenResponseInterface & $response)
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
     * @return LoginWithTokenResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
