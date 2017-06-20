<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class ResetPasswordCommand implements CommandInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $ip4;

    /** @var string */
    private $userAgent;

    public function __construct(string $email, string $ip4, string $userAgent)
    {
        $this->email = $email;
        $this->ip4 = $ip4;
        $this->userAgent = $userAgent;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getIp4(): string
    {
        return $this->ip4;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }
}
