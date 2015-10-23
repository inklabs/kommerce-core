<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\UserPasswordValidator;

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
        $this->assertPasswordValid($password);

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

    /**
     * @param $password
     */
    private function assertPasswordValid($password)
    {
        $user = new User;

        $userPasswordValidator = new UserPasswordValidator;
        $userPasswordValidator->assertPasswordValid($user, $password);
    }
}
