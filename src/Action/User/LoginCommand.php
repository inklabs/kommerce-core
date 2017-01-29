<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\ActionInterface;
use inklabs\kommerce\Lib\Command\CommandInterface;

// TODO: Move ActionInterface to be extended by CommandInterface when #98 is complete
final class LoginCommand implements CommandInterface, ActionInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $remoteIp4;

    /**
     * @param string $email
     * @param string $password
     * @param string $remoteIp4
     */
    public function __construct($email, $password, $remoteIp4)
    {
        $this->email = (string) $email;
        $this->password = (string) $password;
        $this->remoteIp4 = (string) $remoteIp4;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRemoteIp4()
    {
        return $this->remoteIp4;
    }
}
