<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\ActionInterface;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class ResetPasswordCommand implements CommandInterface, ActionInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $ip4;

    /** @var string */
    private $userAgent;

    /**
     * @param string $email
     * @param string $ip4
     * @param string $userAgent
     */
    public function __construct($email, $ip4, $userAgent)
    {
        $this->email = $email;
        $this->ip4 = $ip4;
        $this->userAgent = $userAgent;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIp4()
    {
        return $this->ip4;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }
}
