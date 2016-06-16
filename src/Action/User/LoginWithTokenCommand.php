<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class LoginWithTokenCommand implements CommandInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $token;

    /** @var string */
    private $remoteIp4;

    /**
     * @param string $email
     * @param string $token
     * @param string $remoteIp4
     */
    public function __construct($email, $token, $remoteIp4)
    {
        $this->email = (string) $email;
        $this->token = (string) $token;
        $this->remoteIp4 = (string) $remoteIp4;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getRemoteIp4()
    {
        return $this->remoteIp4;
    }
}
