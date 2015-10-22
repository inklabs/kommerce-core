<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Query\RequestInterface;

final class LoginWithTokenRequest implements RequestInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $token;

    /** @var string */
    private $ip4;

    public function __construct($email, $token, $ip4)
    {
        $this->email = (string) $email;
        $this->token = (string) $token;
        $this->ip4 = (string) $ip4;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getIp4()
    {
        return $this->ip4;
    }
}
