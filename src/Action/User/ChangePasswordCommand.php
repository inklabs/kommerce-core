<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\UserPasswordValidator;
use Ramsey\Uuid\UuidInterface;

final class ChangePasswordCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $userId;

    /** @var string */
    private $password;

    /**
     * @param UuidInterface $userId
     * @param string $password
     */
    public function __construct(UuidInterface $userId, $password)
    {
        $this->assertPasswordValid($password);

        $this->userId = $userId;
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
     * @param string $password
     */
    private function assertPasswordValid($password)
    {
        $user = new User;

        $userPasswordValidator = new UserPasswordValidator;
        $userPasswordValidator->assertPasswordValid($user, $password);
    }
}
