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

    public function __construct(string $email, string $token, string $remoteIp4)
    {
        $this->email = $email;
        $this->token = $token;
        $this->remoteIp4 = $remoteIp4;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRemoteIp4(): string
    {
        return $this->remoteIp4;
    }
}
