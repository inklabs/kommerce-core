<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateUserCommand implements CommandInterface
{
    /** @var UuidInterface  */
    private $userId;

    /** @var UserDTO */
    private $userDTO;

    public function __construct(UserDTO $userDTO)
    {
        $this->userId = Uuid::uuid4();
        $this->userDTO = $userDTO;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getUserDTO(): UserDTO
    {
        return $this->userDTO;
    }
}
