<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class LoginCommand implements CommandInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $remoteIp4;

    public function __construct(string $email, string $password, string $remoteIp4)
    {
        $this->email = $email;
        $this->password = $password;
        $this->remoteIp4 = $remoteIp4;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRemoteIp4(): string
    {
        return $this->remoteIp4;
    }
}
