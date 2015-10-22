<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class ChangePasswordCommand implements CommandInterface
{
    /** @var int */
    private $userId;

    /** @var string */
    private $password;

    /**
     * @param int $userId
     * @param string $password
     */
    public function __construct($userId, $password)
    {
        $this->userId = (int) $userId;
        $this->password = (string) $password;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
