<?php
namespace inklabs\kommerce\Action\User\Query;

final class LoginWithTokenRequest
{
    /** @var string */
    private $email;

    /** @var string */
    private $token;

    /** @var string */
    private $ip4;

    /**
     * @param string $email
     * @param string $token
     * @param string $ip4
     */
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
