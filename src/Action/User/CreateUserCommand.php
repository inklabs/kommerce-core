<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    /** @var UserDTO */
    private $userDTO;

    public function __construct(UserDTO $userDTO)
    {
        $this->userDTO = $userDTO;
    }

    public function getUserDTO()
    {
        return $this->userDTO;
    }
}
